<template>
  <div class="modal-task" v-if="show">
    <div class="container-modal regular">
      <div class="top-modal">
        <h3>{{ isEditing ? 'Editar tarefa' : 'Nova tarefa' }}</h3>
        <div class="close-modal" @click="close">
          <div class="icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M17 7L7 17M7 7L17 17" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </div>
        </div>
      </div>

      <div class="content-modal">
        <form class="form" @submit.prevent="saveTask">
          <div class="block-fields-form">
            <div class="input-wrap no-margin-bottom">
              <input class="input w-input" type="text" v-model="task.nome" required />
              <label class="field-label">Título</label>
            </div>

            <div class="input-wrap no-margin-bottom">
              <input class="input w-input" type="text" v-model="task.descricao" required />
              <label class="field-label">Detalhes</label>
            </div>

            <div class="input-wrap no-margin-bottom">
              <input class="input w-input" type="date" v-model="task.data_limite" required />
              <label class="field-label">Data</label>
            </div>
          </div>
        </form>
      </div>

      <div class="bottom-modal">
        <div class="flex-block-horizontal-right-align">
          <div class="button outlined rounded" @click="close">
            <div>Fechar</div>
          </div>
          <div class="button rounded" @click="saveTask">
            <div>{{ isEditing ? 'Editar' : 'Salvar' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, computed } from 'vue'

import { toRefs } from 'vue'
import { useTaskStore } from '@/stores/taskStore'


const props = defineProps({
  show: Boolean,
  taskToEdit: Object
})
const emit = defineEmits(['close'])

const taskStore = useTaskStore()

const task = reactive({
  nome: '',
  descricao: '',
  finalizado: false,
  data_limite: ''
})

const isEditing = computed(() => !!props.taskToEdit?.id)

// Atualiza o reactive task quando prop mudar
watch(() => props.taskToEdit, (newVal) => {
  if (newVal) {
    task.nome = newVal.nome || ''
    task.descricao = newVal.descricao || ''
    task.finalizado = newVal.finalizado || false
    task.data_limite = newVal.data_limite ? newVal.data_limite.split('T')[0] : ''
  } else {
    task.nome = ''
    task.descricao = ''
    task.finalizado = false
    task.data_limite = ''
  }
}, { immediate: true })

function close() {
  emit('close')
}

async function saveTask() {
  if (isEditing.value) {
    await taskStore.editTask({ id: props.taskToEdit.id, ...task })
  } else {
    await taskStore.addTask(task)
  }
  emit('close')
}


</script>
