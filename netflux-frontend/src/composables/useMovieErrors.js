import { reactive, ref } from "vue";

export function useMovieErrors() {
  const errors = reactive({});
  const globalError = ref(null);

  function setViolations(violations) {
    for (const v of violations) {
      errors[v.propertyPath] = v.message;
    }
  }

  function resetErrors() {
    Object.keys(errors).forEach((key) => delete errors[key]);
    globalError.value = null;
  }

  return {
    errors,
    globalError,
    setViolations,
    resetErrors,
  };
}