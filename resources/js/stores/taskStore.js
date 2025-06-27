import { defineStore } from 'pinia';
import { getTasks, createTask, updateTask, deleteTask, toggleTask } from '@/services/taskService';

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [],
    isLoading: false,
    selectedTask: null,
  }),
  actions: {
    async fetchTasks() {
      this.isLoading = true;
      try {
        const response = await getTasks();
        this.tasks = response.data;
      } catch (error) {
        console.error('Erro ao buscar tarefas:', error);
      } finally {
        this.isLoading = false;
      }
    },
    async addTask(task) {
      try {
        const response = await createTask(task);
        this.tasks.push(response.data);
      } catch (error) {
        console.error('Erro ao adicionar tarefa:', error);
      }
    },
    async editTask(task) {
      try {
        const response = await updateTask(task);
        const index = this.tasks.findIndex(t => t.id === task.id);
        if (index !== -1) this.tasks[index] = response.data;
      } catch (error) {
        console.error('Erro ao editar tarefa:', error);
      }
    },
    async removeTask(id) {
      try {
        await deleteTask(id);
        this.tasks = this.tasks.filter(t => t.id !== id);
      } catch (error) {
        console.error('Erro ao remover tarefa:', error);
      }
    },
    async toggleTaskFinalizado(id) {
      try {
        const response = await toggleTask(id);
        const index = this.tasks.findIndex(t => t.id === id);
        if (index !== -1) this.tasks[index] = response.data;
      } catch (error) {
        console.error('Erro ao alternar status da tarefa:', error);
      }
    },
    selectTask(task) {
      this.selectedTask = task ? { ...task } : null;
    },
    clearSelected() {
      this.selectedTask = null;
    },
  },
});
