<template>
  <form @submit.prevent="handleSubmit" class="form">
    <div class="block-fields-form">
      <div class="input-wrap no-margin-bottom">
        <input v-model="localTask.nome" class="input w-input" type="text" id="nome" required />
        <label for="nome" class="field-label">Título</label>
      </div>
      <div class="input-wrap no-margin-bottom">
        <textarea v-model="localTask.descricao" class="input w-input" id="descricao" required></textarea>
        <label for="descricao" class="field-label">Detalhes</label>
      </div>
      <div class="input-wrap no-margin-bottom">
        <input v-model="localTask.data_limite" class="input w-input" type="date" id="data_limite" required />
        <label for="data_limite" class="field-label">Data</label>
      </div>
    </div>
    <div class="bottom-modal">
      <div class="flex-block-horizontal-right-align">
        <div @click="cancelEdit" v-if="isEditing" class="button outlined rounded">
          <div>Cancelar</div>
        </div>
        <button type="submit" class="button rounded">
          <div>{{ isEditing ? 'Atualizar' : 'Criar' }}</div>
        </button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch, computed } from 'vue';
import { useTaskStore } from '@/stores/taskStore';
import { storeToRefs } from 'pinia';

const taskStore = useTaskStore();
const { selectedTask } = storeToRefs(taskStore);

const localTask = reactive({ nome: '', descricao: '', data_limite: '', finalizado: false });

watch(selectedTask, (newTask) => {
  if (newTask) Object.assign(localTask, newTask);
  else Object.assign(localTask, { nome: '', descricao: '', data_limite: '', finalizado: false });
});

const isEditing = computed(() => !!selectedTask.value);

function handleSubmit() {
  if (isEditing.value) taskStore.editTask(localTask);
  else taskStore.addTask(localTask);
  taskStore.clearSelected();
  resetForm();
}

function cancelEdit() {
  taskStore.clearSelected();
  resetForm();
}

function resetForm() {
  Object.assign(localTask, { nome: '', descricao: '', data_limite: '', finalizado: false });
}
</script>