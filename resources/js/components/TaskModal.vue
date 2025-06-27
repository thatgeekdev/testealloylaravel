<template>
  <div v-if="visible" class="modal-task">
    <div class="container-modal regular">
      <div class="top-modal">
        <h3>{{ task?.id ? 'Editar tarefa' : 'Nova tarefa' }}</h3>
        <div class="close-modal" @click="onClose">
          <div class="icon w-embed">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 7L7 17M7 7L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="content-modal">
        <div class="form-fields w-form">
          <form class="form" @submit.prevent="submit">
            <div class="block-fields-form">
              <div class="input-wrap no-margin-bottom">
                <input
                  id="nome"
                  type="text"
                  class="input w-input"
                  v-model="form.nome"
                  maxlength="256"
                  required
                  autocomplete="off"
                />
                <label for="nome" class="field-label">Título</label>
              </div>

              <div class="input-wrap no-margin-bottom">
                <textarea
                  id="descricao"
                  class="input w-input"
                  v-model="form.descricao"
                  maxlength="1000"
                  rows="3"
                  placeholder="Detalhes da tarefa"
                ></textarea>
                <label for="descricao" class="field-label">Detalhes</label>
              </div>

              <div class="input-wrap no-margin-bottom">
                <input
                  id="data_limite"
                  type="date"
                  class="input w-input"
                  v-model="form.data_limite"
                />
                <label for="data_limite" class="field-label">Data Limite</label>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="bottom-modal">
        <div class="flex-block-horizontal-right-align">
          <div class="button outlined rounded" @click="onClose">
            <div>Fechar</div>
          </div>
          <div class="button rounded" @click="submit">
            <div>{{ task?.id ? 'Editar' : 'Salvar' }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue';
const props = defineProps({ visible: Boolean, task: Object });
const emit = defineEmits(['close', 'save']);

const form = reactive({ nome: '', descricao: '', data_limite: '' });

watch(
  () => props.task,
  (task) => {
    if (task) {
      form.nome = task.nome || '';
      form.descricao = task.descricao || '';
      form.data_limite = task.data_limite
        ? new Date(task.data_limite).toISOString().slice(0, 10)
        : '';
    } else {
      form.nome = '';
      form.descricao = '';
      form.data_limite = '';
    }
  },
  { immediate: true }
);

const submit = () => {
  emit('save', { ...props.task, ...form });
};

const onClose = () => emit('close');
</script>
