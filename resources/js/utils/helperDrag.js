function getArrayKey(arr, keyCheck) {
  const length = arr.length;
  let index = 0;

  var result = [];

  for (index; index < length; index++) {
    result.push(arr[index][keyCheck]);
  }

  return result;
}

export function removeDupEl(arrOrigin, arrChild, keyCheck) {
  const listEl2Del = getArrayKey(arrChild, keyCheck);

  const length = arrOrigin.length;
  let index = 0;

  var result = [];

  for (index; index < length; index++) {
    const isCheck = listEl2Del.includes(arrOrigin[index][keyCheck]);

    if (isCheck === false) {
      result.push(arrOrigin[index]);
    }
  }

  return result;
}
