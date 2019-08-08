const dictionary = {
  pt: {
    messages: {
      cpf: field => `${field} inválido.`,
      required: field => `${field} é obrigatório.`,
      email: field => `${field} inválido.`,
      alpha_spaces: field => `${field} somente letras (a-z)`,
      date_format: field => `${field} Inválido.`,
      regex: field => `${field} Inválido.`,
      min: field => `${field} Inválido ou Incompleto.`
    }
  }
};
export default dictionary;
