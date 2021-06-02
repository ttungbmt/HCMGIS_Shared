Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-page',
      path: '/nova-page/*',
      component: require('./components/Tool').default,
    },
  ])
})
