import Layout from '@/layout'

const broadcastRouter = {
    name: 'Broadcast',
    path: '/broadcast',
    component: Layout,
    redirect: '/broadcast/index',
    meta: {
        title: 'broadcast-manage',
        roles: ['admin'],
        icon: 'message',
    },
    children: [
        {
            name: 'broadcast-create',
            path: 'create',
            component: () => import('@/views/broadcast/create'),
            meta: {
                title: 'broadcast-create',
                roles: ['admin']
            }
        }
    ]
}

export default broadcastRouter