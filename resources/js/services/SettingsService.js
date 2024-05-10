
export function createSettingFormData(setting) {
    const formData = new FormData();
    formData.append('prepared_by', setting.prepared_by || '');
    formData.append('noted_by', setting.noted_by || '');
    formData.append('libre_office_path', setting.libre_office_path);
    formData.append('announcement_running_speed', setting.announcement_running_speed || 1);
    formData.append('display_announcement', setting.display_announcement || '');
    formData.append('source_folder', setting.source_folder || '');
    formData.append('network_source_path', setting?.network_source_path || '');
    formData.append('server_socket_url', setting.server_socket_url || '');
    formData.append('local_socket_url', setting.local_socket_url || '');
    formData.append('_method', 'PUT');
    return formData;
}