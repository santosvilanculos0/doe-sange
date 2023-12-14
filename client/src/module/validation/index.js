export const email = (input) => {
  return /[a-z0-9]+@[a-z]+\.[a-z]{2,3}/.test(input);
};
