<template>
    <div class="tab-content responsive">
        <div class="tab-pane active">
            <div class="row mt-2 mb-2">
                <div class="col-md-7">
                    <input type="text" v-model="filter_term" class="form-control" :placeholder="$t('filter_by_name')">
                </div>
                <div class="col-md-5">
                    <div class="float-right">
                        <router-link :to="{name: 'admin.product.create'}"
                                     class="btn btn-secondary"
                                     tag="button">
                            Add new product
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <app-products v-for="(product, index) in filteredProducts"
                                            :index="index"
                                            :product="product"
                                            :key="product.id"
                                            @removeProduct="removeProduct"></app-products>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import appProducts from './TableRow';

    export default {
        data() {
            return {
                products: [],
                filter_term: ''
            };
        },
        computed: {
            filteredProducts() {
                return this.products.filter(el => {
                    if (!el.name) {
                        return false;
                    }
                    return (el.name).toLowerCase().match((this.filter_term).toLowerCase());
                });
            }
        },
        methods: {
            fetchProducts() {
                axios.get('/admin/products').then(res => {
                    this.products = res.data;
                }).catch(error => console.log(error));
            },
            removeProduct(index) {
                this.products.splice(index, 1);
            }
        },
        components: {
            appProducts
        },
        created() {
            this.fetchProducts();
        }
    }
</script>
