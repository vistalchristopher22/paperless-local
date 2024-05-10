import axios from 'axios';
import { createScheduleFormData, updateScheduleFormData, deleteScheduleFormData, moveScheduleFormData } from "@services/ScheduleService.js";

export function newSchedule(schedule, selectedDate) {
  return axios.post("/api/schedule", createScheduleFormData(schedule, selectedDate));
}

export const updateSchedule = (schedule) => {
  return axios.post(`/api/schedule`, updateScheduleFormData(schedule));
}

export const deleteSchedule = (id) => {
  return axios.post(`/api/schedule/${id}`, deleteScheduleFormData());
}

export function moveSchedule(event) {
  return axios.post(`/api/schedule-move/${event.event.id}`, moveScheduleFormData(event));
}

export function getSchedule(event) {
  return axios.get(`/api/schedule/${event.event.id}`);
}

