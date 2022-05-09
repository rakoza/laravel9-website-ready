<template>
    <form-news
        v-if="showForm"
        @close="closeForm()"
        @data-saved="reloadData()"
        />

    <details-news
        v-else-if="showDetails"
        @close="closeForm()"
        @data-saved="reloadData()"
        />

    <table-news
        v-else
        :news="news"
        @create-news="createNews"
        @show-news="showNews"
        @edit-news="editNews"
        />
</template>

<script>

import TableNews from './table_news'
import FormNews from './form_news'
import DetailsNews from './details_news'

export default {
    components: {
        TableNews,
        FormNews,
        DetailsNews,
    },

    data() {
        return {
            news: [],
        }
    },

    computed: {
        isAdmin() {
            // return appconfig.userRole === 'administrator'
            return true
        },
        showForm() {
            return ['create','edit'].includes(this.$route.query.form)
        },
        showDetails() {
            return ['show'].includes(this.$route.query.form)
        },
    },

    created() {
        this.reloadData()
    },

    methods: {
        reloadData()
        {
            this.$api.news.all()
                .then(data => {
                    this.news = data.news
                })
                .catch(error => {
                    this.$alertError(error.message);
                    throw error
                })
                .finally(() => {
                    // this.isLoading = false
                });
        },
        closeForm()
        {
            this.$router.go(-1)
        },
        createNews()
        {
            this.$router.push({
                name: 'news',
                query: {
                    form: 'create',
                }
            })
        },
        editNews(news)
        {
            this.$router.push({
                name: 'news',
                query: {
                    form: 'edit',
                    id: news.id,
                }
            })
        },
        showNews(news)
        {
            this.$router.push({
                name: 'news',
                query: {
                    form: 'show',
                    id: news.id,
                }
            })
        },
    },
};
</script>
