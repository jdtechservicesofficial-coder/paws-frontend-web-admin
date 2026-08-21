<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Page;
use App\Models\Withdrawal;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $pawllySettings = \Illuminate\Support\Facades\DB::table('settings')->pluck('val', 'name');
            if (isset($pawllySettings['mail_driver'])) {
                config([
                    'mail.default' => $pawllySettings['mail_driver'],
                    'mail.mailers.smtp.host' => $pawllySettings['mail_host'] ?? config('mail.mailers.smtp.host'),
                    'mail.mailers.smtp.port' => $pawllySettings['mail_port'] ?? config('mail.mailers.smtp.port'),
                    'mail.mailers.smtp.encryption' => $pawllySettings['mail_encryption'] ?? config('mail.mailers.smtp.encryption'),
                    'mail.mailers.smtp.username' => $pawllySettings['mail_username'] ?? config('mail.mailers.smtp.username'),
                    'mail.mailers.smtp.password' => $pawllySettings['mail_password'] ?? config('mail.mailers.smtp.password'),
                    'mail.from.address' => $pawllySettings['mail_from'] ?? config('mail.from.address'),
                    'mail.from.name' => $pawllySettings['from_name'] ?? config('mail.from.name'),
                ]);
            }
        } catch (\Exception $e) {}

        $general = gs();
        $activeTemplate = activeTemplate();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'No data';
        $viewShare['pages'] = Page::where('tempname', $activeTemplate)->get();
        view()->share($viewShare);


        view()->composer('admin.partials.tabs.user', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
            ]);
        });
        view()->composer('admin.partials.tabs.deposit', function ($view) {
            $view->with([
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });
        view()->composer('admin.partials.tabs.ticket', function ($view) {
            $view->with([
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
            ]);
        });
        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0,2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->take(10)->get(),
                'adminNotificationCount'=>AdminNotification::where('read_status',0)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if($general && $general->force_ssl){
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();
    }
}
