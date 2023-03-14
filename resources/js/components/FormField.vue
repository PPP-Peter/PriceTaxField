<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        class="price-tax-field"
    >
        <template #field>
            <div class="container-price" >
                <!-- price field-->
                <div class="input-line">
                        <span class="m-2">{{ field.names[0] }}</span>
                        <input class="w-1/3 ml-2 form-control form-input form-input-bordered"
                                :style="{width:'125px'}"
                                :id="field.attribute"
                                type="number"
                                step="0.01"
                                @input ="changePrice"
                                :class="errorClasses"
                                :placeholder="field.name"
                                v-model="value"
                        />
                        <span class="p-2  mr-3 form-control  form-input-bordered bg-transparent">€</span>
                </div>

                <!-- tax field-->
                <div class="input-line">
                    <span class="pl-4">{{ field.names[1] }}</span>
                    <input class=" w-2/3 ml-2 form-control form-input form-input-bordered"
                           :style="{width:'70px'}"
                           v-model="taxValue"
                           @input ="changePrice"
                           :id="field.attribute"
                           type="number"
                    />
                    <span class="p-2  mr-3 form-control  form-input-bordered bg-transparent">%</span>
                </div>

                <!-- price with tax field-->
                <div class="input-line">
                    <span class="pl-4">{{ field.names[2] }}</span>
                    <input class="w-1/3 ml-2  form-control form-input form-input-bordered"
                           :style="{width:'125px'}"
                           v-model="withTaxValue"
                           @input ="changePriceWithTax"
                           :id="field.attribute"
                           type="number"
                    />
                    <span class="p-2 form-control  form-input-bordered bg-transparent">€</span>
                </div>
            </div>
        </template>
    </DefaultField>

</template>

<style scoped>
.input-line{
    white-space:nowrap;
}
.container-price{
    display: inline-flex
}
</style>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
export default {
    mixins: [FormField, HandlesValidationErrors],
    props: ['resourceName', 'resourceId', 'field'],
    data(){
        return {
            value: 0,
            withTaxValue: 0,
            taxValue: 0,
        }
    },
    methods: {
        changePrice(){

            if (this.value ) {
                clearTimeout(this.debounce)
                this.debounce = setTimeout(() => {
                    this.value = this.value.toFixed(2)
                }, 1100)
            }

            //if (this.taxValue == 0 ) return
            let result = this.value * (this.taxValue *0.01 + 1)
            this.withTaxValue = result.toFixed(2);

        },
        changePriceWithTax(){
            let result =  this.withTaxValue /   (this.taxValue*0.01 + 1)
            this.value = result.toFixed(2);
        },
        changeTax(){},

        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },
        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.dbNames[2], this.withTaxValue)
            formData.append(this.field.dbNames[1], this.taxValue )
            formData.append(this.field.attribute, this.value || '')
        },
    },
    mounted() {
        this.value ? this.value = this.value.toFixed(2) : this.value = '0.00'

        this.taxValue = document.querySelector('#' + this.field.dbNames[1] + '-productdetail-text-field').value
        this.withTaxValue = Number(document.querySelector('#' + this.field.dbNames[2] + '-productdetail-text-field').value).toFixed(2)
        document.querySelector('.price-tax-field').previousElementSibling.previousElementSibling.style.display = "none"
        document.querySelector('.price-tax-field').previousElementSibling.style.display = "none"
    },
}
</script>
