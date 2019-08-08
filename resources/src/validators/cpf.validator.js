import CpfValidate from './rules/cpf'
const validator = {
  getMessage (field, args) {
    return 'Invalid CPF'
  },
  validate (value, args) {
    return CpfValidate(value)
  }
}
export default validator
