import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-price-tax-field', IndexField)
  app.component('detail-price-tax-field', DetailField)
  app.component('form-price-tax-field', FormField)
})
