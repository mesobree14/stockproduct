export function useState(initialValue, callback) {
  let value = initialValue;
  const get = () => value;
  const set = (newValue) => {
    value = newValue;
    callback?.(value);
  };
  return [get, set];
}
