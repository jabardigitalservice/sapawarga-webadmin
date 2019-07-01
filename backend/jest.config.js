module.exports = {
  verbose: false,
  moduleFileExtensions: ['js', 'jsx', 'json', 'vue'],
  transformIgnorePatterns: [
    'node_modules/(?!(babel-jest|jest-vue-preprocessor)/)'
  ],
  transform: {
    '^.+\\.vue$': 'vue-jest',
    '.+\\.(css|styl|less|sass|scss|svg|png|jpg|ttf|woff|woff2)$': 'jest-transform-stub',
    '^.+\\.jsx?$': 'babel-jest'
  },
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/src/$1'
  },
  snapshotSerializers: ['jest-serializer-vue'],
  testMatch: [
    '**/tests/unit/**/*.spec.(js|jsx|ts|tsx)|**/__tests__/*.(js|jsx|ts|tsx)'
  ],
  collectCoverageFrom: ['src/utils/**/*.{js,vue}', '!src/utils/auth.js', '!src/utils/request.js', 'src/components/**/*.{js,vue}', 'src/views/**/*.{js,vue}', 'src/store/**/*.{js,vue}', 'src/api/**/*.{js,vue}', 'src/filters/**/*.{js,vue}'],
  coverageDirectory: '<rootDir>/tests/unit/coverage',
  'collectCoverage': true,
  'coverageReporters': [
    'html',
    'lcov',
    'text-summary'
  ],
  testURL: 'http://localhost/'
}
