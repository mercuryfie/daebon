module.exports = {
    parserOptions: {
      parser: '@babel/eslint-parser',
      requireConfigFile: false,
      ecmaVersion: 2020,
      sourceType: 'module',
    },
    env: {
      browser: true,
      es2021: true,
      node: true,
    },
    extends: [
      'eslint:recommended',
      'plugin:vue/vue3-essential'  // Vue3 기본 규칙 사용 시
    ],
    plugins: ['vue'],
    rules: {
      // 원하는 규칙 추가 가능
    },
  };
  