import moment from 'moment';

export function createScheduleFormData(schedule, selectedDate) {
    let formData = new FormData();
    formData.append("name", schedule.value.name);
    formData.append("time", schedule.value.time);
    formData.append("description", schedule.value.short_description);
    formData.append("venue", schedule.value.venue);
    formData.append("type", schedule.value.type);
    formData.append("reference_session", schedule.value.reference_session);
    formData.append("guests", 0);
    formData.append("selected_date", selectedDate.value);
    formData.append("order_of_business", schedule.value.order_of_business || "");
  
    return formData;
  }
  
export function updateScheduleFormData(schedule) {
  let formData = new FormData();
  formData.append("id", schedule.value.id);
  formData.append("name", schedule.value.name);
  formData.append("time", schedule.value.time);
  formData.append("description", schedule.value.short_description || "");
  formData.append("venue", schedule.value.venue);
  formData.append("type", schedule.value.type);
  formData.append("reference_session", schedule.value.reference_session);
  formData.append("order_of_business", schedule.value.order_of_business || "");
  formData.append("guests", 0);
  formData.append("selected_date", schedule.value.date);
  formData.append("_method", "PUT");

  return formData;
}

export function deleteScheduleFormData() {
  let formData = new FormData();
  formData.append("_method", "DELETE");

  return formData;
}

export function moveScheduleFormData(event) {
  let formData = new FormData();
  formData.append("moveDate", moment(event.event.start).format("YYYY-MM-DD"));
  formData.append("_method", "put");
  return formData;
}

export function initializeScheduleForEvent(calendarSchedule) {
  return {
    id: "",
    name: "",
    date: moment(calendarSchedule.start).format("YYYY-MM-DD"),
    time: "",
    short_description: "",
    venue: "",
    type: "",
    reference_session: "",
  };
}

export function initializeScheduleFromResponse(response, event) {
  return {
    id: response.data.id,
    date: moment(response.data.date_and_time).format("YYYY-MM-DD"),
    time: response.data.time,
    name: response.data.name,
    short_description: response.data.description,
    venue: response.data.venue,
    type: response.data.type,
    reference_session: response.data.reference_session,
    order_of_business: parseInt(response.data.order_of_business),
    committees_count: response.data.committees_count,
    selectedDate: event.startStr,
  };
}