import { useState } from 'react';
import { Table, TableProvider, CTableDeleteLink, useTable, TableActions } from '@mxjs/a-table';
import { CEditLink, CNewBtn } from '@mxjs/a-clink';
import { Page, PageActions } from '@mxjs/a-page';
import { SearchForm, SearchItem } from '@mxjs/a-form';
import classNames from 'classnames';
import PropTypes from 'prop-types';

const removeEmptyChildren = (data) => {
  return data.map(item => {
    if (item.children) {
      if (0 === item.children.length) {
        delete item.children;
      } else {
        item.children = removeEmptyChildren(item.children);
      }
    }
    return item;
  });
};

const getIds = (data) => {
  let ids = [];
  data.forEach(item => {
    if (item.children) {
      ids.push(item.id);
      ids = ids.concat(getIds(item.children));
    }
  });
  return ids;
};

const ExpandIcon = ({expanded, onExpand}) => {
  const iconPrefix = 'ant-table-row-expand-icon';
  return (
    <>
      <span className="ant-table-row-indent indent-level-0"></span>
      <button
        className={classNames(iconPrefix, {
          [iconPrefix + '-expanded']: expanded,
          [iconPrefix + '-collapsed']: !expanded,
        })}
        onClick={onExpand}
        title={expanded ? '关闭全部行' : '展开全部行'}
      >
      </button>
    </>
  );
};

ExpandIcon.propTypes = {
  expanded: PropTypes.bool,
  onExpand: PropTypes.func,
};

const Index = () => {
  const [table] = useTable();

  const [data, setData] = useState([]);
  const [expanded, setExpanded] = useState(false);
  const [expandedRowKeys, setExpandedRowKeys] = useState([]);
  const handleClickExpand = () => {
    setExpanded(!expanded);
    setExpandedRowKeys(expanded ? [] : getIds(data));
  };

  return (
    <Page>
      <TableProvider>
        <PageActions>
          <CNewBtn/>
        </PageActions>

        <SearchForm>
          <SearchItem label="名称" name={['search', 'name:ct']}/>
        </SearchForm>

        <Table
          tableApi={table}
          expandedRowKeys={expandedRowKeys}
          onExpand={(expanded, record) => {
            if (expanded) {
              setExpandedRowKeys(expandedRowKeys.concat(record.id));
            } else {
              setExpandedRowKeys(expandedRowKeys.filter(id => id !== record.id));
            }
          }}
          postData={(data) => {
            data = removeEmptyChildren(data);
            setData(data);
            return data;
          }}
          pagination={{
            pageSize: 500,
          }}
          columns={[
            {
              title: <>
                <ExpandIcon expanded={expanded} onExpand={handleClickExpand}/>
                名称
              </>,
              dataIndex: 'name',
            },
            {
              title: '简介',
              dataIndex: 'description',
            },
            {
              title: '顺序',
              dataIndex: 'sort',
              sorter: true,
            },
            {
              title: '操作',
              dataIndex: 'id',
              render: (id) => (
                <TableActions>
                  <CEditLink id={id}/>
                  <CTableDeleteLink id={id}/>
                </TableActions>
              ),
            },
          ]}
        />
      </TableProvider>
    </Page>
  );
};

export default Index;
