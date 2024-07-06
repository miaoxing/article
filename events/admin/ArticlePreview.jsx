import { useEffect, useState } from 'react';
import PropTypes from 'prop-types';
import $ from 'miaoxing';
import { Empty } from 'antd';
import './list.scss';
import defaultCover from '../../images/default-cover.svg';

const ImageTopList = ({articles}) => {
  return articles.map((article) => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <img className="max-w-full h-auto mb-2" src={article.cover || defaultCover}/>
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
        <div className="list-col !grow-0 !basis-[72px] h-[72px] w-[72px]">
          <img className="h-full" src={article.cover || defaultCover}/>
        </div>
        <div className="list-col align-middle">
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

const TitleLeftImageRightList = ({articles}) => {
  return articles.map(article => (
    <li key={article.id}>
      <a className="list-item" href="#">
        <div className="list-col align-middle">
          <h4 className="list-title">
            {article.title}
          </h4>
          <div className="list-text">
            {article.intro}
          </div>
        </div>
        <div className="list-col !grow-0 !basis-[87px] h-[72px] w-[87px]">
          <img className="h-full max-w-full" src={article.cover || defaultCover}/>
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
          <ul className="list list-indented mb-0">
            <Tpl articles={articles}/>
          </ul>
          :
          <div className="overflow-hidden">
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
