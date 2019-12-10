<template>
    <div class="tab-content">
        <div class="tab-pane active">
            <h4 class="mt-2 mb-2">Add new product</h4>
            <div class="form-group">
                <label>Name *</label>
                <input type="text"
                       v-model="form.name"
                       data-vv-name="name"
                       data-vv-as="Name"
                       :class="{'form-control': true, 'is-invalid': errors.has('name') }"
                       v-validate="'required'">
                <span class="invalid-feedback" role="alert" v-show="errors.has('name')">
                    <strong>{{ errors.first('name') }}</strong>
                </span>
            </div>
            <div class="form-group">
                <label>Price *</label>
                <input type="text"
                       v-model="form.price"
                       data-vv-name="price"
                       data-vv-as="Price"
                       :class="{'form-control': true, 'is-invalid': errors.has('price') }"
                       v-validate="'required'">
                <span class="invalid-feedback" role="alert" v-show="errors.has('price')">
                    <strong>{{ errors.first('price') }}</strong>
                </span>
            </div>

            <div class="form-group">
                <button class="btn btn-secondary" @click="store">{{ $t("save") }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {}
            };
        },
        methods: {
            store() {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        axios.post('/admin/product/store', this.form).then(res => {
                            this.$toastr.s(this.$t("saved"));
                            this.$router.push({name: 'admin.products'});
                        }).catch(error => console.log(error));
                    }
                });
            }
        }
    }
</script>
