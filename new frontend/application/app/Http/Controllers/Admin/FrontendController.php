<?php

namespace App\Http\Controllers\Admin;

use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function templates()
    {
        $pageTitle = 'Templates';
        $temPaths = array_filter(glob('core/resources/views/templates/*'), 'is_dir');
        foreach ($temPaths as $key => $temp) {
            $arr = explode('/', $temp);
            $tempname = end($arr);
            $templates[$key]['name'] = $tempname;
            $templates[$key]['image'] = asset($temp) . '/preview.jpg';
        }
        $extra_templates = json_decode(getTemplates(), true);
        return view('admin.frontend.templates', compact('pageTitle', 'templates', 'extra_templates'));

    }

    public function templatesActive(Request $request)
    {
        $general = GeneralSetting::first();

        $general->active_template = $request->name;
        $general->save();

        $notify[] = ['success', strtoupper($request->name).' template activated successfully'];
        return back()->withNotify($notify);
    }

    public function seoEdit()
    {
        $pageTitle = 'SEO Configuration';
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        if(!$seo){
            $data_values = '{"keywords":[],"description":"","social_title":"","social_description":"","image":null}';
            $data_values = json_decode($data_values, true);
            $frontend = new Frontend();
            $frontend->data_keys = 'seo.data';
            $frontend->data_values = $data_values;
            $frontend->save();
        }
        return view('admin.frontend.seo', compact('pageTitle', 'seo'));
    }



    public function frontendSections($key)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }
        $content = Frontend::where('data_keys', $key . '.content')->orderBy('id','desc')->first();
        if ($key === 'blog') {
            $elements = \Illuminate\Support\Facades\DB::table('blogs')->orderBy('id','desc')->get()->map(function($blog) {
                $frontend = new \stdClass();
                $frontend->id = $blog->id;
                $frontend->data_keys = 'blog.element';
                
                $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $blog->id)->first();
                $image = $media ? $media->file_name : null;
                
                $frontend->data_values = (object) [
                    'title' => $blog->name,
                    'description' => $blog->description,
                    'image' => $image,
                ];
                return $frontend;
            });
        } else {
            $elements = Frontend::where('data_keys', $key . '.element')->orderBy('id')->orderBy('id','desc')->get();
        }
        $pageTitle = $section->name ;
        return view('admin.frontend.index', compact('section', 'content', 'elements', 'key', 'pageTitle'));
    }




    public function frontendContent(Request $request, $key)
    {
        $purifier = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type', 'id');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = $purifier->purify($input);
        }
        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $imgJson = @getPageSections()->$key->$type->images;
        $validation_rule = [];
        $validation_message = [];
        foreach ($request->except('_token', 'video') as $input_field => $val) {
            if ($input_field == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validation_rule['image_input.'.$imgValKey] = ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])];
                    $validation_message['image_input.'.$imgValKey.'.image'] = keyToTitle($imgValKey).' must be an image';
                    $validation_message['image_input.'.$imgValKey.'.mimes'] = keyToTitle($imgValKey).' file type not supported';
                }
                continue;
            }elseif($input_field == 'seo_image'){
                $validation_rule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
            $validation_rule[$input_field] = 'required';
        }
        $request->validate($validation_rule, $validation_message, ['image_input' => 'image']);
        if ($request->id) {
            if ($key === 'blog' && $request->type === 'element') {
                $content = (object) ['id' => $request->id];
            } else {
                $content = Frontend::findOrFail($request->id);
            }
        } else {
            $content = Frontend::where('data_keys', $key . '.' . $request->type)->first();
            if (!$content || $request->type == 'element') {
                $content = new Frontend();
                $content->data_keys = $key . '.' . $request->type;
                if ($key !== 'blog' || $request->type !== 'element') {
                    $content->save();
                }
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = fileUploader($request->image_input,getFilePath('seo'), getFileSize('seo'), @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload the image'];
                    return back()->withNotify($notify);
                }
            }
        }else{
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson,$type,$key,$imgData,$imgKey,@$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Couldn\'t upload the image'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        
        if ($key === 'blog' && $type === 'element') {
            $blogId = $request->id;
            if ($blogId) {
                \Illuminate\Support\Facades\DB::table('blogs')->where('id', $blogId)->update([
                    'name' => $inputContentValue['title'],
                    'description' => $inputContentValue['description'],
                    'updated_at' => now(),
                ]);
            } else {
                $blogId = \Illuminate\Support\Facades\DB::table('blogs')->insertGetId([
                    'name' => $inputContentValue['title'],
                    'description' => $inputContentValue['description'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (isset($request->image_input['image'])) {
                $file = $request->image_input['image'];
                if (is_file($file)) {
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $mime = $file->getMimeType();
                    
                    \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $blogId)->delete();
                    
                    $mediaId = \Illuminate\Support\Facades\DB::table('media')->insertGetId([
                        'model_type' => 'Modules\Blog\Models\Blog',
                        'model_id' => $blogId,
                        'uuid' => (string) \Illuminate\Support\Str::uuid(),
                        'collection_name' => 'blog_image',
                        'name' => 'blog-image',
                        'file_name' => $filename,
                        'mime_type' => $mime,
                        'disk' => 'public',
                        'conversions_disk' => 'public',
                        'size' => $size,
                        'manipulations' => '[]',
                        'custom_properties' => '[]',
                        'generated_conversions' => '[]',
                        'responsive_images' => '[]',
                        'order_column' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    
                    $pawllyStoragePath = base_path('../../storage/app/public/' . $mediaId);
                    if (!is_dir($pawllyStoragePath)) {
                        mkdir($pawllyStoragePath, 0755, true);
                    }
                    $file->move($pawllyStoragePath, $filename);
                }
            }
            $notify[] = ['success', 'Blog content has been updated successfully'];
            return back()->withNotify($notify);
        }
        
        $content->data_values = $inputContentValue;
        $content->save();
        $notify[] = ['success', 'Content has been updated successfully'];
        return back()->withNotify($notify);
    }



    public function frontendElement($key, $id = null)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        unset($section->element->modal);
        $pageTitle = $section->name . ' Items';
        if ($id) {
            if ($key === 'blog') {
                $blog = \Illuminate\Support\Facades\DB::table('blogs')->where('id', $id)->first();
                $data = new \App\Models\Frontend();
                $data->id = $blog->id;
                $data->data_keys = 'blog.element';
                $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $blog->id)->first();
                $data->data_values = (object) [
                    'title' => $blog->name,
                    'description' => $blog->description,
                    'image' => $media ? $media->file_name : null,
                ];
            } else {
                $data = Frontend::findOrFail($id);
            }
            return view('admin.frontend.element', compact('section', 'key', 'pageTitle', 'data'));
        }
        return view('admin.frontend.element', compact('section', 'key', 'pageTitle'));
    }




    protected function storeImage($imgJson,$type,$key,$image,$imgKey,$old_image = null)
    {
        $path = 'assets/images/frontend/' . $key;
        if ($type == 'element' || $type == 'content') {
            $size = @$imgJson
            ->$imgKey->size;
            $thumb = @$imgJson
            ->$imgKey->thumb;
        }else{
            $path = getFilePath($key);
            $size = getFileSize($key);
            $thumb = @fileManager()->$key()->thumb;
        }
        return fileUploader($image, $path, $size, $old_image, $thumb);
    }

    public function remove($id)
    {
        $frontend = Frontend::find($id);
        if (!$frontend) {
            // Check if it's a blog
            $blog = \Illuminate\Support\Facades\DB::table('blogs')->where('id', $id)->first();
            if ($blog) {
                \Illuminate\Support\Facades\DB::table('blogs')->where('id', $id)->delete();
                $media = \Illuminate\Support\Facades\DB::table('media')->where('model_type', 'Modules\Blog\Models\Blog')->where('model_id', $id)->first();
                if ($media) {
                    \Illuminate\Support\Facades\DB::table('media')->where('id', $media->id)->delete();
                    $pawllyStoragePath = base_path('../../storage/app/public/' . $media->id);
                    if (is_dir($pawllyStoragePath)) {
                        \Illuminate\Support\Facades\File::deleteDirectory($pawllyStoragePath);
                    }
                }
                $notify[] = ['success', 'Blog removed successfully'];
                return back()->withNotify($notify);
            }
            abort(404);
        }
        $key = explode('.', @$frontend->data_keys)[0];
        $type = explode('.', @$frontend->data_keys)[1];
        if (@$type == 'element' || @$type == 'content') {
            $path = 'assets/images/frontend/' . $key;
            $imgJson = @getPageSections()->$key->$type->images;
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    fileManager()->removeFile($path . '/' . @$frontend->data_values->$imgKey);
                    fileManager()->removeFile($path . '/thumb_' . @$frontend->data_values->$imgKey);
                }
            }
        }
        $frontend->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }


}
