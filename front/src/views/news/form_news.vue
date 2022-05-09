<template>
    <div>
        <!-- Header -->
        <page-header :title="$tc('news')" :subtitle="subtitle">
        <!-- Buttons -->
            <div class="level-item buttons">
                <b-button
                    v-if="formMode === 'edit'"
                    @click="deleteNews"
                    type="is-danger"
                    icon-pack="fas"
                    icon-right="trash">
                    {{ $t('delete') }}
                </b-button>
            </div>
        </page-header>

        <section class="section">
            <!-- Form -->
            <form @input="form.clearField($event);" >
                <div v-if="isLoading">...</div>
                <div class="container" v-else>

                    <div class="columns">
                        <div class="column">
                            <figure class="image is-1by1">
                              <img src="https://bulma.io/images/placeholders/480x480.png">
                            </figure>
                        </div>

                        <div class="column">
                            <!-- title -->
                            <b-field
                                class="required"
                                :label="$t('title')"
                                :type="form.hasError('title')"
                                :message="form.errorMessage('title')">
                                <b-input
                                    v-model="form.title"
                                    name="title"
                                    :placeholder="$t('title')">
                                </b-input>
                            </b-field>

                            <!-- text -->
                            <b-field
                                :label="$t('text')"
                                :type="form.hasError('text')"
                                :message="form.errorMessage('text')">
                                <b-input
                                    type="textarea"
                                    maxlength="1000"
                                    v-model="form.text"
                                    name="text"
                                    :placeholder="$t('text')">
                                </b-input>
                            </b-field>

                            <!-- active -->
                            <b-field
                                v-if="isAdmin"
                                :label="$t('is_published')"
                                :type="form.hasError('is_published')"
                                :message="form.errorMessage('is_published')">
                                <b-checkbox
                                    name="is_published"
                                    v-model="form.is_published"
                                    :true-value="1"
                                    :false-value="0">
                                    {{ form.is_published ? $t('yes') : $t('no') }}
                                </b-checkbox>
                            </b-field>
                        </div>

                    </div>

                    <!--Card Footer-->
                    <footer class="is-flex is-flex-direction-row-reverse">
                        <div class="buttons">
                            <modal-button-cancel @click="$emit('close')"></modal-button-cancel>
                            <modal-button-save @click="submit()"></modal-button-save>
                        </div>
                    </footer>

                </div>
            </form>
            <!-- forma -->
        </section>
    </div>
</template>

<script>

export default {
    props: [],

    data() {
        let item = {
            is_published: 0,
        };

        const form = new this.$form(item)

        return {
            form,
            isLoading: true,
        }
    },

    created() {
        if(this.formMode !== 'edit') {
            this.isLoading = false
            return
        }

        const id = this.$route.query.id

        this.$api.news.get(id)
            .then(({news}) => {
                const item = this.$pick(news, [
                    'title',
                    'text',
                    'is_published',
                ]);

                this.form.setData(item)
                // this.$forceUpdate()
            })
            .catch(error => {
                this.$alertError(error.message);
                throw error
            })
            .finally(() => {
                this.isLoading = false
            });
    },

    computed: {
        formMode() {
            return this.$route.query.form
        },
        subtitle() {
            return this.formMode === 'create'
                ? this.$tc('create')
                : this.$tc('edit')
        },
        isAdmin() {
            // return appconfig.userRole === 'administrator'
            return true
        },
    },

    methods: {
        submit()
        {
            const url = this.formMode === 'create'
                ? '/news'
                : '/news/' + this.$route.query.id

            this.form
                .submit(this.formMode, url)
                .then(() => {
                    const message = this.formMode == 'create'
                        ? 'Uspješno kreirano'
                        : 'Izmjene su uspješno sačuvane'

                    this.$notify(message, 'is-success')
                    this.$emit('data-saved')
                    this.$emit('close')
                })
                .catch(() => {})
        },
        deleteNews()
        {
            const id = this.$route.query.id

            this.$api.news.delete(id)
                .then(() => {
                    this.$notify('Novost je izbrisana', 'is-success')
                    this.$emit('data-saved')
                    this.$emit('close')
                })
                .catch(error => {
                    this.$alertError(error.message);
                    throw error
                })
        }
    }

};
</script>

