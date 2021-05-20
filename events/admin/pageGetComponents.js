import React from 'react';
import {ProfileOutlined} from '@ant-design/icons';
import ArticlePreview from './ArticlePreview';
import ArticleConfig from './ArticleConfig';

export default [
  {
    type: 'article',
    name: '图文列表',
    icon: <ProfileOutlined/>,
    preview: ArticlePreview,
    config: ArticleConfig,
    default: {
      source: 'all',
      categoryIds: [],
      articleIds: [],
      num: 3,
      tpl: 1,
    },
  },
];
