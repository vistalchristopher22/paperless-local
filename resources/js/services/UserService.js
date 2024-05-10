
export function createNewUser() {
  return {
    first_name : '',
    middle_name : '',
    last_name : '',
    suffix : '',
    username : '',
    password : '',
    status : '',
    division : '',
  };
}

export function initializeUserFromProps(account) {
    return {
      first_name: account.first_name,
      middle_name: account.middle_name,
      last_name: account.last_name,
      suffix: account.suffix,
      username: account.username,
      password: "",
      account_type: account.account_type,
      status: account.status,
      division: account.division,
    }
}
export function createUserFormData(user) {
  let formData = new FormData();
  formData.append("first_name", user.first_name || '');
  formData.append("middle_name", user.middle_name || '');
  formData.append("last_name", user.last_name || '');
  formData.append("suffix", user.suffix || '');
  formData.append("username", user.username || '');
  formData.append("password", user.password || '');
  formData.append("account_type", user.account_type || '');
  formData.append("status", user.status || '');
  formData.append("division", user.division || '');
  return formData;
}

export function updateUserFormData(user) {
    let formData = new FormData();
    formData.append("first_name", user.first_name || '');
    formData.append("middle_name", user.middle_name || '');
    formData.append("last_name", user.last_name || '');
    formData.append("suffix", user.suffix || '');
    formData.append("username", user.username || '');
    formData.append("password", user.password || '');
    formData.append("account_type", user.account_type || '');
    formData.append("status", user.status || '');
    formData.append("division", user.division || '');
    formData.append("_method", "PUT");
    return formData;
  }