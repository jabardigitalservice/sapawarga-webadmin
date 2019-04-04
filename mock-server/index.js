const jsonServer = require('json-server')
const server = jsonServer.create()
const router = jsonServer.router('db.json')
const middlewares = jsonServer.defaults()

router.render = (req, res) => {
  if (Array.isArray(res.locals.data)) {
    res.json({
    	status: 200,
    	success: true,
      data: {
      	items: res.locals.data,
        _meta: {
          totalCount: 100,
          pageCount: 5,
          currentPage: 1,
          perPage: 20
        }
      }
    })
  } else {
    res.json({
      status: 200,
      success: true,
      data: res.locals.data
    })
  }
}

server.use(jsonServer.rewriter({
  '/api/v1/aspirasi/categories': '/aspirasi-categories',
  '/api/v1/aspirasi/categories/:id': '/aspirasi-categories/:id',
  '/api/v1/aspirasi': '/aspirasi',
  '/api/v1/aspirasi/:id': '/aspirasi/:id'
}))

server.use(middlewares)
server.use(router)
server.listen(3000, '0.0.0.0', () => {
  console.log('JSON Server is running')
})