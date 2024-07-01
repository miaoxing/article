import { useEffect, useState } from 'react';
import PropTypes from 'prop-types';
import $ from 'miaoxing';
import { Empty } from 'antd';
import { Box, Image } from '@mxjs/a-box';
import './list.scss';
import defaultCover from '../../images/default-cover.svg';

const ImageTopList = ({articles}) => {
  return articles.map((article) => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <Image maxW="full" h="auto" mb={2} src={article.cover || defaultCover}/>
        <h4 className="list-title">
          {article.title}
        </h4>
        {article.intro && <div className="list-text">
          {article.intro}
        </div>}
      </a>
    </li>
  ));
};

const OnlyTitleList = ({articles}) => {
  return articles.map((article) => (
    <li key={article.id}>
      <a className="list-item list-has-arrow">
        <h4 className="list-title">
          {article.title}
        </h4>
        <i className="bm-angle-right list-arrow"/>
      </a>
    </li>
  ));
};

const ImageLeftTitleRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <Box className="list-col" flex="0 0 72px !important" h="72px" w="72px!">
          <Image h="100%" src={article.cover || defaultCover}/>
        </Box>
        <Box className="list-col" verticalAlign="middle">
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </Box>
      </a>
    </li>
  ));
};

const TitleLeftImageRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <Box className="list-col" verticalAlign="middle">
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </Box>
        <Box className="list-col" flex="0 0 87px !important" h="72px" w="87px">
          <Image h="100%" maxW="100%" src={article.cover || defaultCover}/>
        </Box>
      </a>
    </li>
  ));
};

const tpls = {
  1: ImageTopList,
  2: OnlyTitleList,
  3: ImageLeftTitleRightList,
  4: TitleLeftImageRightList,
};

const ArticlePreview = (
  {
    source = 'all',
    categoryIds = [],
    articleIds = [],
    num = 3,
    tpl = 1,
  },
) => {
  const [articles, setArticles] = useState([]);

  useEffect(() => {
    let search = {};
    switch (source) {
      case 'category':
        if (categoryIds.length === 0) {
          setArticles([]);
          return;
        }

        search = {
          categoryId: categoryIds,
        };
        break;

      case 'article':
        if (articleIds.length === 0) {
          setArticles([]);
          return;
        }

        num = undefined;
        search = {
          id: articleIds,
        };
        break;

      case 'all':
        break;
    }

    $.get({
      url: 'articles',
      params: {
        sortField: 'id',
        limit: num,
        search,
      },
    }).then(({ret}) => {
      if (ret.isErr()) {
        $.ret(ret);
        return;
      }
      setArticles(ret.data);
    });
  }, [source, num, categoryIds.join(), articleIds.join()]);

  const Tpl = tpls[tpl || 1];

  return (
    <>
      {
        articles.length ?
          <Box as="ul" mb={0} className="list list-indented">
            <Tpl articles={articles}/>
          </Box>
          :
          <Box overflow="hidden">
            <Empty image={Empty.PRESENTED_IMAGE_SIMPLE}/>
          </Box>
      }
    </>
  );
};

ArticlePreview.propTypes = {
  source: PropTypes.string,
  categoryIds: PropTypes.array,
  articleIds: PropTypes.array,
  num: PropTypes.number,
  tpl: PropTypes.number,
};

export default ArticlePreview;
