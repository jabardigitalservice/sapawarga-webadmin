const jsonServer = require('json-server')
const server = jsonServer.create()
const router = jsonServer.router('db.json')
const middlewares = jsonServer.defaults()

router.render = (req, res) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', '*');
  res.header('Access-Control-Request-Headers', '*');
  res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  res.header('Access-Control-Request-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  
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

server.post('/api/v1/aspirasi/approval/:id', (req, res) => {
  res.json({
    status: 200,
    success: true
  })
})

server.post('/api/v1/aspirasi/likes/:id', (req, res) => {
  res.json({
    status: 200,
    success: true
  })
})

server.post('/api/v1/attachments', (req, res) => {
  res.json({
    status: 200,
    success: true,
    data: {
      photo_url: "http://103.122.5.71/api/storage/image/avatars/Lv9rvmvCMHt09yEbd30ggPl4cR81UJcH.jpg"
    }
  })
})

server.post('/api/v1/polling/vote/:id', (req, res) => {
  res.json({
    status: 200,
    success: true
  })
})

server.use(jsonServer.bodyParser)
server.use((req, res, next) => {
  if (req.method === 'POST') {
    req.body.created_at = 1554076800
    req.body.updated_at = 1554076800
  }
  // Continue to JSON Server router
  next()
})

server.use(jsonServer.rewriter({
  '/api/v1/categories': '/categories',
  '/api/v1/categories/:id': '/categories/:id',
  '/api/v1/phone-books': '/phone-books',
  '/api/v1/phone-books/:id': '/phone-books/:id',
  '/api/v1/aspirasi-me': '/aspirasi',
  '/api/v1/aspirasi': '/aspirasi',
  '/api/v1/aspirasi/:id': '/aspirasi/:id',
  '/api/v1/broadcast': '/broadcast',
  '/api/v1/broadcast/:id': '/broadcast/:id',
  '/api/v1/polling': '/polling',
  '/api/v1/polling/:id': '/polling/:id',
  '/api/v1/upload': '/upload',
}))

server.use(middlewares)
server.use(router)
server.listen(3000, '0.0.0.0', () => {
  console.log('JSON Server is running')
})
