import {useEffect, useState} from 'react';
import {Table, TableProvider, useTable} from '@mxjs/a-table';
import Media from '@mxjs/a-media';
import {CloseCircleFilled, DownCircleFilled, UpCircleFilled} from '@ant-design/icons';
import $ from 'miaoxing';
import {Avatar, Button, Modal} from 'antd';
import Icon from '@mxjs/icons';
import {PageActions} from '@mxjs/a-page';
import {SearchForm, SearchItem} from '@mxjs/a-form';
import api from '@mxjs/api';
import appendUrl from 'append-url';
import PropTypes from 'prop-types';
import {NewBtn} from '@mxjs/a-button';
import {css, spacing} from '@mxjs/css';
import defaultCover from '../../images/default-cover.svg';

const cardClass = css({
  position: 'relative',
  mb4: true,
  p6: true,
  shadowTiny: true,
  border: 1,
  borderColor: 'gray100',
  ':hover': {
    '> .toolbar': {
      display: 'block',
    },
  },
});

const toolbarClass = css({
  display: 'none',
  position: 'absolute',
  top: -spacing(4),
  right: -spacing(2),
  textXL: true,
  '> a': {
    ml1: true,
    gray400: true,
  },
});

const arrayMove = (array, from, to) => {
  array.splice(to, 0, array.splice(from, 1)[0]);
  return [...array];
};

const arrayRemove = (array, index) => {
  array.splice(index, 1);
  return [...array];
};

const ArticlePicker = ({value = [], onChange}) => {
  const [table] = useTable();

  // 确定选中的数据
  const [articles, setArticles] = useState([]);

  // Modal 中的数据
  // 需要受控，以便打开 modal 选中已选的图文
  const [visible, setVisible] = useState(false);
  const [selectedRowKeys, setSelectedRowKeys] = useState(value);

  useEffect(() => {
    if (!value.length) {
      setArticles([]);
      return;
    }

    api.get(appendUrl('articles', {sortField: 'id', search: {id: value}}))
      .then(({ret}) => {
        if (ret.isErr()) {
          $.ret(ret);
          return;
        }
        setArticles(ret.data);
      });
  }, [value.join(',')]);

  const move = (from, to) => {
    onChange(arrayMove(value, from, to));
    setArticles(arrayMove(articles, from, to));
  };

  const remove = (index) => {
    onChange(arrayRemove(value, index));
    setArticles(arrayRemove(articles, index));
  };

  return (
    <>
      <div>
        {articles.map((article, index) => {
          return <Media key={article.id} className={cardClass}>
            <div className={'toolbar ' + toolbarClass}>
              {index !== 0 && <a href="#" onClick={(e) => {
                e.preventDefault();
                move(index, index - 1);
              }}>
                <UpCircleFilled/>
              </a>}
              {index !== articles.length - 1 && <a href="#" onClick={(e) => {
                e.preventDefault();
                move(index, index + 1);
              }}>
                <DownCircleFilled/>
              </a>}
              <a href="#" onClick={(e) => {
                e.preventDefault();
                $.confirm('删除后不能还原，确认删除？', result => {
                  if (result) {
                    remove(index);
                  }
                });
              }}>
                <CloseCircleFilled/>
              </a>
            </div>
            <Avatar src={article.cover || defaultCover} shape="square" size={48}/>
            <Media.Body>
              {article.title}
            </Media.Body>
          </Media>;
        })}
        <Button block type="dashed" onClick={() => {
          setVisible(true);
        }}>
          <Icon type="mi-popup"/>
          选 择
        </Button>
      </div>
      <Modal
        title="选择图文"
        visible={visible}
        width={800}
        bodyStyle={{
          padding: '1rem',
        }}
        onOk={() => {
          onChange(selectedRowKeys);
          setVisible(false);
        }}
        onCancel={() => {
          setSelectedRowKeys(value);
          setVisible(false);
        }}
      >
        <TableProvider>
          <PageActions>
            <NewBtn href={$.url('admin/articles/new')} target="_blank">
              添 加{' '}<Icon type="mi-external-link"/>
            </NewBtn>
            <Button onClick={() => {
              table.reload();
            }}>刷新</Button>
          </PageActions>
          <SearchForm>
            <SearchItem label="标题" name={['search', 'title:ct']}/>
          </SearchForm>
          <Table
            tableApi={table}
            url={$.apiUrl('articles')}
            rowSelection={{
              selectedRowKeys,
              onChange: (selectedRowKeys) => {
                setSelectedRowKeys(selectedRowKeys);
              },
            }}
            columns={[
              {
                title: '标题',
                dataIndex: 'title',
              },
              {
                title: '创建时间',
                dataIndex: 'createdAt',
                width: 180,
              },
              {
                title: '最后更改时间',
                dataIndex: 'updatedAt',
                width: 180,
              },
            ]}
          />
        </TableProvider>
      </Modal>
    </>
  );
};

ArticlePicker.propTypes = {
  value: PropTypes.array,
  onChange: PropTypes.func,
};

export default ArticlePicker;
