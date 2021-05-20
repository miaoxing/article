import React, {useState, useEffect} from 'react';
import PropTypes from 'prop-types';
import {css} from '@mxjs/css';
import $ from 'miaoxing';
import {Empty} from 'antd';
import './list.scss';

const defaultImage = window.location.origin + $.url('plugins/page/images/default-swiper.svg');

const listCss = css({
  mb: 0,
});

const imgCss = css({
  maxW: '100%',
  h: 'auto',
  mb: 2,
});

const ImageTopList = ({articles}) => {
  return articles.map((article) => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <img css={imgCss} src={article.cover || defaultImage}/>
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

const imageLeftCss = css({
  // 样式被 list.scss 覆盖
  flex: '0 0 72px !important',
  h: '72px',
  w: '72px !important',
});

const alignSelfCenter = css({
  verticalAlign: 'middle',
});

const sideImgCss = css({
  h: '100%',
});

const ImageLeftTitleRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <div className="list-col" css={imageLeftCss}>
          <img css={sideImgCss} src={article.cover || defaultImage}/>
        </div>
        <div className="list-col" css={alignSelfCenter}>
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

const imageRightCss = css({
  flex: '0 0 87px !important',
  h: '72px',
  w: '87px !important',
});

const TitleLeftImageRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <div className="list-col" css={alignSelfCenter}>
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </div>
        <div className="list-col" css={imageRightCss}>
          <img css={sideImgCss} src={article.cover || defaultImage}/>
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

const emptyContainerCss = css({
  overflow: 'hidden',
});

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
    }).then(ret => {
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
          <ul className="list list-indented" css={listCss}>
            <Tpl articles={articles}/>
          </ul>
          :
          <div css={emptyContainerCss}>
            <Empty image={Empty.PRESENTED_IMAGE_SIMPLE}/>
          </div>
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
