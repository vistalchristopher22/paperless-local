import axios from 'axios';
import { createSettingFormData } from '@services/SettingsService';
export function saveNewSetting(setting) {
    return axios.post('/settings/update', createSettingFormData(setting));
}