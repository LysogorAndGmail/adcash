<template>
    <tr>
        <th>{{ index + 1 }}</th>
        <td v-if="!editing">{{ product.name }}</td>
        <td v-else>
            <div class="form-group">
                <input type="text"
                       v-model="product.name"
                       data-vv-name="name"
                       data-vv-as="Name"
                       :class="{'form-control': true, 'is-invalid': errors.has('name') }"
                       v-validate="'required'">
                <span class="invalid-feedback" role="alert" v-show="errors.has('name')">
                    <strong>{{ errors.first('name') }}</strong>
                </span>
            </div>
        </td>
        <td v-if="!editing">{{ product.price }}</td>
        <td v-else>
            <div class="form-group">
                <input type="text"
                       v-model="product.price"
                       data-vv-name="price"
                       data-vv-as="Price"
                       :class="{'form-control': true, 'is-invalid': errors.has('price') }"
                       v-validate="'required'">
                <span class="invalid-feedback" role="alert" v-show="errors.has('price')">
                    <strong>{{ errors.first('price') }}</strong>
                </span>
            </div>
        </td>
        <td>
            <span class="float-right">
                <a href="javascript:void(0)" @click="edit(product)" v-if="!editing">{{ $t("edit") }}</a> <span
                    v-if="!editing">|</span>
                <a href="javascript:void(0)" @click="destroy(product.id)" v-if="!editing">{{ $t("delete") }}</a>
                <a href="javascript:void(0)" @click="cancelEdit(product)" v-if="editing">{{ $t("cancel") }}</a> <span
                    v-if="editing">|</span>
                <a href="javascript:void(0)" @click="update(product.id)" v-if="editing">{{ $t("update") }}</a>
            </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['product', 'index'],
        data() {
            return {
                editing: false,
                form: {},
                original: {}
            };
        },
        methods: {
            edit(product) {
                this.form = product;
                this.original = Object.assign({}, product);
                this.editing = true;
            },
            cancelEdit(product) {
                Object.assign(product, this.original);
                this.form = this.original = null;
                this.editing = false;
            },
            update(id) {
                this.$validator.validate().then(isValid => {
                    if (isValid) {
                        axios.put('/admin/product/' + id + '/update', this.form).then(res => {
                            this.$toastr.s(this.$t("updated"));
                            this.editing = false;
                        });
                    }
                });
            },
            destroy(id) {
                if (!window.confirm(this.$t("delete") + '?')) {
                    return false;
                }

                axios.delete('/admin/product/' + id + '/destroy').then(res => {
                    this.$toastr.s(this.$t("deleted"));
                    this.$emit('removeProduct', this.index);
                }).catch(error => {
                    this.$toastr.e(error.response.data.message);
                });
            },
        }
    }
</script>
