export function handleNextPage(length) {
  const ITEMS = 10;

  if (length >= 10) {
    return Math.floor(length / ITEMS) + 1;
  }

  return 1;
}
