import {useState, useEffect} from 'react';
import PropTypes from 'prop-types';
import $ from 'miaoxing';
import {Empty} from 'antd';
import {Box, Image} from '@mxjs/box';
import {css} from '@mxjs/css';
import './list.scss';

const defaultImage = window.location.origin + $.url('plugins/page/images/default-swiper.svg');

const imgClass = css({
  maxW: '100%',
  h: 'auto',
  mb2: true,
});

const ImageTopList = ({articles}) => {
  return articles.map((article) => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <img className={imgClass} src={article.cover || defaultImage}/>
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

const imageLeftClass = css({
  // 样式被 list.scss 覆盖
  flex: '0 0 72px !important',
  h: '72px',
  w: '72px !important',
});

const verticalAlignMiddle = css({
  verticalAlign: 'middle',
});

const ImageLeftTitleRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <div className={'list-col ' + imageLeftClass}>
          <Image h="100%" src={article.cover || defaultImage}/>
        </div>
        <div className={'list-col ' + verticalAlignMiddle}>
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </div>
      </a>
    </li>
  ));
};

const imageRightClass = css({
  flex: '0 0 87px !important',
  h: '72px',
  w: '87px !important',
});

const TitleLeftImageRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <div className={'list-col ' + verticalAlignMiddle}>
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </div>
        <div className={'list-col' + imageRightClass}>
          <Image h="100%" maxW="100%" src={article.cover || defaultImage}/>
        </div>
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
      url: $.apiUrl('articles', {
        sortField: 'id',
        limit: num,
        search,
      }),
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
          <Box as="ul" mb0 className="list list-indented">
            <Tpl articles={articles}/>
          </Box>
          :
          <Box overflowHidden>
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

export {defaultImage};
