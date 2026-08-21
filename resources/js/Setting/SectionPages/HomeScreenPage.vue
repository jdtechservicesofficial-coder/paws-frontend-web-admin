<template>
  <form @submit="formSubmit">
    <div>
      <CardTitle title="Home Screen" icon="fas fa-home"></CardTitle>
    </div>

    <div class="form-group" v-for="role in roles" :key="role.name">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" :for="'category-' + role.name">{{ role.label }}</label>
        <div class="form-check form-switch">
          <input class="form-check-input" :true-value="1" :false-value="0" :checked="formValues[role.name] == 1 ? true : false" :name="role.name" :id="'category-' + role.name" type="checkbox" v-model="formValues[role.name]" />
        </div>
      </div>
    </div>

    <SubmitButton :IS_SUBMITED="IS_SUBMITED"></SubmitButton>
  </form>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import CardTitle from '@/Setting/Components/CardTitle.vue'
import { STORE_URL, GET_URL } from '@/vue/constants/setting'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { createRequest } from '@/helpers/utilities'
import SubmitButton from './Forms/SubmitButton.vue'

const { storeRequest } = useRequest()
const IS_SUBMITED = ref(false)

const roles = [
  { name: 'show_groomer', label: 'Show Groomers' },
  { name: 'show_boarder', label: 'Show Boarders' },
  { name: 'show_vet', label: 'Show Veterinarians' },
  { name: 'show_trainer', label: 'Show Trainers' },
  { name: 'show_walker', label: 'Show Walkers' },
  { name: 'show_day_taker', label: 'Show Daycare Takers' },
  { name: 'show_pet_sitter', label: 'Show Pet Sitters' }
]

const formValues = ref({
  show_groomer: 0,
  show_boarder: 0,
  show_vet: 0,
  show_trainer: 0,
  show_walker: 0,
  show_day_taker: 0,
  show_pet_sitter: 1
})

onMounted(() => {
  const customData = roles.map(r => r.name).join(',')
  createRequest(GET_URL(customData)).then((response) => {
    roles.forEach(r => {
      formValues.value[r.name] = response[r.name] !== undefined && response[r.name] !== null ? parseInt(response[r.name]) : formValues.value[r.name]
    })
  })
})

const display_submit_message = (res) => {
  IS_SUBMITED.value = false
  if (res.status) {
    window.successSnackbar(res.message)
  } else {
    window.errorSnackbar(res.message)
  }
}

const formSubmit = (e) => {
  e.preventDefault()
  IS_SUBMITED.value = true
  
  storeRequest({
    url: STORE_URL,
    body: formValues.value,
    type: 'file'
  }).then((res) => display_submit_message(res))
}
</script>
