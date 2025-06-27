<template>
  <div class="block-tasks">
    <div
      v-for="task in tasks"
      :key="task.id"
      class="task"
    >
      <label class="w-checkbox checkbox-field">
        <input
          type="checkbox"
          :checked="task.finalizado"
          @change="$emit('toggle', task.id)"
          class="w-checkbox-input w-checkbox-input--inputType-custom checkbox margin-right-10"
        />
        <span
          class="checkbox-label w-form-label"
          :class="{ checked: task.finalizado }"
        >
          {{ task.nome }}
        </span>
      </label>

      <div class="date-button margin-left-40">
        <div>{{ formatDate(task.data_limite) }}</div>
      </div>

      <div v-if="task.descricao" class="task-details">
        <div>{{ task.descricao }}</div>
      </div>

      <div class="remove-task">
        <div class="button outlined rounded small" @click="$emit('delete', task.id)">
          <div class="icon w-embed">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="edit-task">
        <div class="button outlined rounded small" @click="$emit('edit', task)">
          <div class="icon w-embed">
            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 20h9"/>
              <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
  tasks: Array
});

const emit = defineEmits(['delete', 'toggle', 'edit']);

function formatDate(dateString) {
  if (!dateString) return 'Sem data';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', {
    weekday: 'short', day: '2-digit', month: '2-digit', year: 'numeric'
  });
}
</script>