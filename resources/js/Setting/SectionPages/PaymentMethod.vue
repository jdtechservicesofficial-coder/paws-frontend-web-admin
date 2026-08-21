<template>
  <form @submit="formSubmit">
    <div>
      <CardTitle title="Payment Method" icon="fa-solid fa-coins"></CardTitle>
    </div>

    <div class="form-group">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="payment_method_paystack">{{ $t('setting_payment_method.lbl_paystack') }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :value="paystack_payment_method" :checked="paystack_payment_method == 1 ? true : false" name="paystack_payment_method" id="payment_method_paystack" type="checkbox" v-model="paystack_payment_method" />
        </div>
      </div>
    </div>
    <div v-if="paystack_payment_method == 1">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="paystack_secretkey">{{ $t('setting_payment_method.lbl_secret_key') }}</label>
            <input type="text" class="form-control" v-model="paystack_secretkey" id="paystack_secretkey" name="paystack_secretkey" :errorMessage="errors.paystack_secretkey" :errorMessages="errorMessages.paystack_secretkey" />
            <p class="text-danger" v-for="msg in errorMessages.paystack_secretkey" :key="msg">{{ msg }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="paystack_publickey">{{ $t('setting_payment_method.lbl_app_key') }}</label>
            <input type="text" class="form-control" v-model="paystack_publickey" id="paystack_publickey" name="paystack_publickey" :errorMessage="errors.paystack_publickey" :errorMessages="errorMessages.paystack_publickey" />
            <p class="text-danger" v-for="msg in errorMessages.paystack_publickey" :key="msg">{{ msg }}</p>
          </div>
        </div>
      </div>
    </div>

    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import { useField, useForm } from 'vee-validate'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'
//
import * as yup from 'yup'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { onMounted } from 'vue'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'
const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)
//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      razor_payment_method: data.razor_payment_method || 0,
      razorpay_secretkey: data.razorpay_secretkey || '',
      razorpay_publickey: data.razorpay_publickey || '',
      str_payment_method: data.str_payment_method || 0,
      stripe_secretkey: data.stripe_secretkey || '',
      stripe_publickey: data.stripe_publickey || '',
      paystack_payment_method: data.paystack_payment_method || 0,
      paystack_secretkey: data.paystack_secretkey || '',
      paystack_publickey: data.paystack_publickey || '',
      paypal_payment_method: data.paypal_payment_method || 0,
      paypal_secretkey: data.paypal_secretkey || '',
      paypal_clientid: data.paypal_clientid || '',
      flutterwave_payment_method: data.flutterwave_payment_method || 0,
      flutterwave_secretkey: data.flutterwave_secretkey || '',
      flutterwave_publickey: data.flutterwave_publickey || '',
      airtel_payment_method: data.airtel_payment_method || 0,
      airtel_secretkey: data.airtel_secretkey || '',
      airtel_clientid: data.airtel_clientid || '',
      phonepay_payment_method: data.phonepay_payment_method || 0,
      phonepay_app_id: data.phonepay_app_id || '',
      phonepay_merchant_id: data.phonepay_merchant_id || '',
      phonepay_salt_key: data.phonepay_salt_key || '',
      phonepay_salt_index: data.phonepay_salt_index || '',
      midtrans_payment_method: data.midtrans_payment_method || 0,
      midtrans_clientid: data.midtrans_clientid || '',
      cinet_payment_method: data.cinet_payment_method || 0,
      cinet_siteid: data.cinet_siteid || '',
      cinet_apikey: data.cinet_apikey || '',
      cinet_secretkey: data.cinet_secretkey || '',
      sadad_payment_method: data.sadad_payment_method || 0,
      sadad_id: data.sadad_id || '',
      sadad_key: data.sadad_key || '',
      sadad_domain: data.sadad_domain || ''
    }
  })
}
const validationSchema = yup.object({
  paystack_secretkey: yup.string().test('paystack_secretkey', 'Must be a valid Paystack key', function (value) {
    if (this.parent.paystack_payment_method == '1' && !value) {
      return false
    }
    return true
  }),
  paystack_publickey: yup.string().test('paystack_publickey', 'Must be a valid Paystack Publickey', function (value) {
    if (this.parent.paystack_payment_method == '1' && !value) {
      return false
    }
    return true
  })
})
const { handleSubmit, errors, resetForm } = useForm({ validationSchema })
const errorMessages = ref({})
const { value: razor_payment_method } = useField('razor_payment_method')
const { value: razorpay_secretkey } = useField('razorpay_secretkey')
const { value: razorpay_publickey } = useField('razorpay_publickey')
const { value: str_payment_method } = useField('str_payment_method')
const { value: stripe_secretkey } = useField('stripe_secretkey')
const { value: stripe_publickey } = useField('stripe_publickey')
const { value: paystack_payment_method } = useField('paystack_payment_method')
const { value: paystack_secretkey } = useField('paystack_secretkey')
const { value: paystack_publickey } = useField('paystack_publickey')
const { value: paypal_payment_method } = useField('paypal_payment_method')
const { value: paypal_secretkey } = useField('paypal_secretkey')
const { value: paypal_clientid } = useField('paypal_clientid')
const { value: flutterwave_payment_method } = useField('flutterwave_payment_method')
const { value: flutterwave_secretkey } = useField('flutterwave_secretkey')
const { value: flutterwave_publickey } = useField('flutterwave_publickey')
const { value: airtel_payment_method } = useField('airtel_payment_method')
const { value: airtel_secretkey } = useField('airtel_secretkey')
const { value: airtel_clientid } = useField('airtel_clientid')
const { value: phonepay_payment_method } = useField('phonepay_payment_method')
const { value: phonepay_app_id } = useField('phonepay_app_id')
const { value: phonepay_merchant_id } = useField('phonepay_merchant_id')
const { value: phonepay_salt_key } = useField('phonepay_salt_key')
const { value: phonepay_salt_index } = useField('phonepay_salt_index')
const { value: midtrans_payment_method } = useField('midtrans_payment_method')
const { value: midtrans_clientid } = useField('midtrans_clientid')
const { value: cinet_payment_method } = useField('cinet_payment_method')
const { value: cinet_siteid } = useField('cinet_siteid')
const { value: cinet_apikey } = useField('cinet_apikey')
const { value: cinet_secretkey } = useField('cinet_secretkey')
const { value: sadad_payment_method } = useField('sadad_payment_method')
const { value: sadad_id } = useField('sadad_id')
const { value: sadad_key } = useField('sadad_key')
const { value: sadad_domain } = useField('sadad_domain')

watch(
  () => razor_payment_method.value,
  (value) => {
    if (value == '0') {
      razorpay_secretkey.value = ''
      razorpay_publickey.value = ''
    }
  },
  { deep: true }
)
watch(
  () => str_payment_method.value,
  (value) => {
    if (value == '0') {
      stripe_secretkey.value = ''
      stripe_publickey.value = ''
    }
  },
  { deep: true }
)
watch(
  () => paystack_payment_method.value,
  (value) => {
    if (value == '0') {
      paystack_secretkey.value = ''
      paystack_publickey.value = ''
    }
  },
  { deep: true }
)
watch(
  () => paypal_payment_method.value,
  (value) => {
    if (value == '0') {
      paypal_secretkey.value = ''
      paypal_clientid.value = ''
    }
  },
  { deep: true }
)
watch(
  () => flutterwave_payment_method.value,
  (value) => {
    if (value == '0') {
      flutterwave_secretkey.value = ''
      flutterwave_publickey.value = ''
    }
  },
  { deep: true }
)

watch(
  () => airtel_payment_method.value,
  (value) => {
    if (value == '0') {
      airtel_secretkey.value = ''
      airtel_clientid.value = ''
    }
  },
  { deep: true }
)

watch(
  () => phonepay_payment_method.value,
  (value) => {
    if (value == '0') {
      phonepay_app_id.value = ''
      phonepay_merchant_id.value = ''
      phonepay_salt_key.value = ''
      phonepay_salt_index.value = ''
    }
  },
  { deep: true }
)

watch(
  () => midtrans_payment_method.value,
  (value) => {
    if (value == '0') {
      midtrans_clientid.value = ''
    }
  },
  { deep: true }
)
watch(
  () => cinet_payment_method.value,
  (value) => {
    if (value == '0') {
      cinet_siteid.value = ''
      cinet_apikey.value = ''
      cinet_secretkey.value = ''
    }
  },
  { deep: true }
)

watch(
  () => sadad_payment_method.value,
  (value) => {
    if (value == '0') {
      sadad_id.value = ''
      sadad_key.value = ''
      sadad_domain.value = ''
    }
  },
  { deep: true }
)
// message
const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
    if (res.all_message) {
      errorMessages.value = res.all_message
    } else {
      errorMessages.value = res.errors
    }
  }
}

//fetch data
const data = 'razor_payment_method,razorpay_secretkey,razorpay_publickey,str_payment_method,stripe_secretkey,stripe_publickey,paystack_payment_method,paystack_secretkey,paystack_publickey,paypal_payment_method,paypal_secretkey,paypal_clientid,flutterwave_payment_method,flutterwave_secretkey,flutterwave_publickey,airtel_payment_method,airtel_secretkey,airtel_clientid,phonepay_payment_method,phonepay_app_id,phonepay_merchant_id,phonepay_salt_key,phonepay_salt_index,midtrans_payment_method,midtrans_clientid,cinet_payment_method,cinet_siteid,cinet_apikey,cinet_secretkey,sadad_payment_method,sadad_id,sadad_key,sadad_domain,'
onMounted(() => {
  createRequest(GET_URL(data)).then((response) => {
    setFormData(response)
  })
})

//Form Submit
const formSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  const newValues = {}
  Object.keys(values).forEach((key) => {
    if (values[key] !== '') {
      newValues[key] = values[key] || ''
    }
    console.log(newValues)
  })
  storeRequest({
    url: STORE_URL,
    body: newValues
  }).then((res) => display_submit_message(res))
})

defineProps({
  label: { type: String, default: '' },
  modelValue: { type: String, default: '' },
  placeholder: { type: String, default: '' },
  errorMessage: { type: String, default: '' },
  errorMessages: { type: Array, default: () => [] }
})
</script>
