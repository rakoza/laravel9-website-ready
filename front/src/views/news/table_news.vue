<template>
    <div>
        <!-- Header -->
        <page-header :title="$tc('news', 2)">
            <!-- Buttons -->
            <div class="level-item buttons">
                <b-button
                    @click="$emit('create-news')"
                    type="is-primary"
                    icon-pack="fas"
                    icon-right="circle-plus">
                    {{ $t('create') }}
                </b-button>
            </div>
        </page-header>

        <section class="section">
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <th style="width: 30px;"></th>
                        <th style="width: 150px;">{{ $t('created_at') }}</th>
                        <!-- <th style="width: 150px;"></th> -->
                        <th>{{ $t('title') }} / {{ $t('text') }}</th>
                        <th style="width: 90px;" class="has-text-right">{{ $t('is_published') }}</th>
                        <th style="width: 100px;"></th>
                    </thead>

                    <tbody>
                        <tr v-for="(item,index) in news" :key="index">
                            <td>{{ index + 1 }}.</td>
                            <td>{{ item.created_at | dd_mm_yyyy }}</td>
                            <!-- <td></td> -->
                            <td>
                                <h1>{{ item.title }}</h1>
                                {{ item.text }}
                            </td>
                            <td class="has-text-right"
                                :class="{'has-text-danger has-text-weight-bold': !item.is_published}"
                                >
                                {{ item.is_published ? 'Da' : 'Ne' }}
                            </td>
                            <td class="py-1">
                                <div class="is-flex is-flex-wrap-nowrap is-justify-content-flex-end">
                                    <!-- Edit -->
                                    <!-- <b-button
                                        size="is-small is-rounded is-lowercase"
                                        @click="$emit('show-news', item)"
                                        type="is-light"
                                        icon-pack="fas"
                                        icon-right="link">
                                        {{ $t('details') }}
                                    </b-button> -->
                                    <!-- Edit -->
                                    <b-button
                                        size="is-small is-rounded is-lowercase"
                                        @click="$emit('edit-news', item)"
                                        type="is-primary is-light"
                                        icon-pack="fas"
                                        icon-right="edit">
                                        {{ $t('edit') }}
                                    </b-button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

<script>

export default {
    props: ['news'],
}
</script>
