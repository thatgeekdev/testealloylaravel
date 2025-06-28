<template>
  <div class="task" @click="handleClick">
    <label class="w-checkbox checkbox-field" :for="`checkbox-${task.id}`" @click.stop>
      <div class="w-checkbox-input w-checkbox-input--inputType-custom checkbox margin-right-10"
        :class="{ checked: task.finalizado }"></div>
      <input type="checkbox" :id="`checkbox-${task.id}`" style="opacity:0;position:absolute;z-index:-1"
        :checked="task.finalizado" @change.stop="toggle" />
      <span class="checkbox-label w-form-label" :class="{ checked: task.finalizado }">
        {{ task.nome }}
      </span>
    </label>

    <div class="date-button margin-left-40">
      <div>{{ formatarData(task.data_limite) }}</div>
    </div>

    <div v-if="task.descricao" class="task-details">
      <div>{{ task.descricao }}</div>
    </div>


    <div class="  task flex items-center justify-between gap-4 p-2 border-b" @click.stop="remove">
      <div class="icon w-embed">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
      </div>
    </div>

  </div>
</template>

<script setup>
import { useTaskStore } from '@/stores/taskStore'
import { format, isToday, isTomorrow, parseISO } from 'date-fns'
import { ptBR } from 'date-fns/locale'


const props = defineProps({ task: Object })
const emit = defineEmits(['edit'])
const store = useTaskStore()

const toggle = () => {
  store.toggleTaskFinalizado(props.task.id)
}

const remove = () => {
  store.removeTask(props.task.id)
}

const handleClick = () => {
  emit('edit', props.task)
}

const formatarData = (data) => {
  if (!data) return ''
  const dataFormatada = parseISO(data)
  if (isToday(dataFormatada)) return 'Hoje'
  if (isTomorrow(dataFormatada)) return 'Amanhã'
  return format(dataFormatada, "EEEE, dd/MM/yyyy", { locale: ptBR })
}
</script>
