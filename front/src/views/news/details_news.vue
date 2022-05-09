<template>
    <div>
        <!-- Header -->
        <page-header :title="$tc('news')" :subtitle="$t('details')">
            <!-- Buttons -->
            <div class="level-item buttons">
            </div>
        </page-header>

        <section class="section">
            <div v-if="isLoading.news">...</div>
            <div class="container" v-else>

                <div class="columns">
                    <div class="column">
                        {{ news }}
                    </div>

                    <div class="column">
                        right column
                    </div>

                </div>

                <!--Card Footer-->
                <!-- <footer class="is-flex is-flex-direction-row-reverse">
                    <div class="buttons">
                        <modal-button-cancel @click="$emit('close')"></modal-button-cancel>
                        <modal-button-save @click="submit()"></modal-button-save>
                    </div>
                </footer> -->

            </div>

        </section>
    </div>
</template>

<script>

export default {
    props: [],

    data() {
        return {
            news: null,
            isLoading: {
                news: true,
            },
        }
    },

    created() {
        this.getNewsDetails()
    },

    computed: {
        isAdmin() {
            // return appconfig.userRole === 'administrator'
            return true
        },
    },

    methods: {
        getNewsDetails()
        {
            const id = this.$route.query.id

            this.$api.news.get(id)
                .then(({news}) => {
                    this.news = news
                })
                .catch(error => {
                    this.$alertError(error.message);
                    throw error
                })
                .finally(() => {
                    this.isLoading.news = false
                });
        },
    }

};
</script>

