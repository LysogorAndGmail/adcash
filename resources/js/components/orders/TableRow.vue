<template>
    <tr>
        <td>{{ index + 1 }}</td>
        <td>{{ order.full_name }}</td>
        <td>{{ order.name }}</td>
        <td>{{ order.product_price }} EUR</td>
        <td>{{ order.product_count }}</td>
        <td>{{ order.order_sum }} EUR</td>
        <td>{{ order.created_at }}</td>
        <td>
            <span class="float-right">
                <router-link
                        :to="{name: 'order.edit', params:{order_id:order.id}}" tag="a">
                    {{ $t("edit") }}
                </router-link>
                <span> | </span>
                <a href="javascript:void(0)"
                   @click="destroy(order.id)">{{ $t("delete") }}</a>
            </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: ['order', 'index'],
        computed: {
        },
        methods: {
            destroy(id) {
                if (!window.confirm(this.$t("delete") + '?')) {
                    return false;
                }
                axios.delete('/order/' + id + '/destroy').then(res => {
                    this.$toastr.s(this.$t("deleted"));
                    this.$emit('removeOrder', this.index);
                }).catch(error => {
                    this.$toastr.e(error.response.data.message);
                });
            }
        }
    }
</script>
