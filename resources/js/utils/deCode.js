import ConstValue from '../../../const/const_value.json';

export function deCodeRole(str) {
  let code;

  switch (str) {
    case ConstValue.ROLE.ADMIN:
      code = ConstValue.ROLE_CODE.ADMIN;
      break;
    case ConstValue.ROLE.TRAINING_STAFF:
      code = ConstValue.ROLE_CODE.TRAINING_STAFF;
      break;
    case ConstValue.ROLE.TRAINERS:
      code = ConstValue.ROLE_CODE.TRAINERS;
      break;
    case ConstValue.ROLE.TRAINEE:
      code = ConstValue.ROLE_CODE.TRAINEE;
      break;
    default:
      code = null;
  }

  return code;
}

export function getNameRole(code) {
  const listNameRole = ConstValue.ROLE_NAME;

  code = code - 1;

  if (code >= 0 && code < listNameRole.length) {
    return listNameRole[code];
  } else {
    return -1;
  }
}

export function changeBoolean2Number(arr, key) {
  const length = arr.length;
  let index = 0;

  for (index; index < length; index++) {
    arr[index][key] = +!!arr[index][key];
  }

  return arr;
}

export function changeNumber2Boolean(arr, key) {
  const length = arr.length;
  let index = 0;

  for (index; index < length; index++) {
    arr[index][key] = !!arr[index][key];
  }

  return arr;
}

export function isCountDup(arr, key, val) {
  const length = arr.length;
  let index = 0;
  let result = 0;

  for (index; index < length; index++) {
    if (arr[index][key] === val) {
      result = result + 1;
    }
  }

  return result;
}
