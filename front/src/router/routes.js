import Dashboard from '@/views/dashboard/App'
import Users from '@/views/users/App'
import News from '@/views/news/App'

export default [
    {
        path: '/profile',
        name: 'profile',
        // route level code-splitting
        // this generates a separate chunk (profile.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "profile" */ '../views/profile/App.vue')
    },
    {
        path: `/dashboard`,
        name: 'dashboard',
        component: Dashboard,
    },
    {
        path: `/users`,
        name: 'users',
        component: Users,
    },
    {
        path: `/news`,
        name: 'news',
        component: News,
    },
]
