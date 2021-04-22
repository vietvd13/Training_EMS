/**
 * Adds two numbers together.
 * @param {string} strings The original string
 * @param {string} keys The key variable of template.
 * @return {string} complited string after join
 */
export function template(strings, ...keys) {
  return function(...values) {
    const dict = values[values.length - 1] || {};
    const result = [strings[0]];
    keys.forEach(function(key, i) {
      const value = Number.isInteger(key) ? values[key] : dict[key];
      result.push(value, strings[i + 1]);
    });
    return result.join('');
  };
}
