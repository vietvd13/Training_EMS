export function getKey(array, key) {
  const result = [];
  const length = array.length;
  let index = 0;

  for (index; index < length; index++) {
    result.push(array[index][key]);
  }

  return result;
}

export function reNameKey(array, oldKey, newKey) {
  const length = array.length;
  let index = 0;

  for (index; index < length; index++) {
    array[index][newKey] = array[index][oldKey];
    delete array[index][oldKey];
  }

  return array;
}
