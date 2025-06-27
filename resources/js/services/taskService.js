import axios from 'axios';

const API_URL = '/api/tasks';

export const getTasks = async () => {
  try {
    return await axios.get(API_URL);
  } catch (error) {
    console.error('Erro ao obter tarefas:', error);
    throw error;
  }
};

export const createTask = async (task) => {
  try {
    return await axios.post(API_URL, task);
  } catch (error) {
    console.error('Erro ao criar tarefa:', error);
    throw error;
  }
};

export const updateTask = async (task) => {
  try {
    return await axios.put(`${API_URL}/${task.id}`, task);
  } catch (error) {
    console.error('Erro ao atualizar tarefa:', error);
    throw error;
  }
};

export const deleteTask = async (id) => {
  try {
    return await axios.delete(`${API_URL}/${id}`);
  } catch (error) {
    console.error('Erro ao deletar tarefa:', error);
    throw error;
  }
};

export const toggleTask = async (id) => {
  try {
    return await axios.patch(`${API_URL}/${id}/toggle`);
  } catch (error) {
    console.error('Erro ao alternar status da tarefa:', error);
    throw error;
  }
};
