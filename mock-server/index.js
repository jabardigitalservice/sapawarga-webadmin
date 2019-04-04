const jsonServer = require('json-server')
const server = jsonServer.create()
const router = jsonServer.router('db.json')
const middlewares = jsonServer.defaults()

router.render = (req, res) => {
  res.json({
  	status: 200,
  	success: true,
    data: res.locals.data
  })
}

server.use(jsonServer.rewriter({
  '/api/v1/:resource': '/:resource',
  '/api/v1/:resource/:id': '/:resource/:id'
}))

server.use(middlewares)
server.use(router)
server.listen(3000, '0.0.0.0', () => {
  console.log('JSON Server is running')
})