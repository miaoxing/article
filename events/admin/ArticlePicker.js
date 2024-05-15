import { useEffect, useState } from 'react';
import {Button, Modal} from 'antd';
import {Table, TableProvider, useTable} from '@mxjs/a-table';
import {SearchForm, SearchItem} from '@mxjs/a-form';
import {PageActions} from '@mxjs/a-page';
import Icon from '@mxjs/icons';
import $ from 'miaoxing';
import PropTypes from 'prop-types';
import {NewBtn} from '@mxjs/a-button';

const ArticlePicker = ({pickerRef, linkPicker, value}) => {
  const [table] = useTable();
  const [id, setId] = useState(value.id);
  const [title, setTitle] = useState();
  const [open, setOpen] = useState(true);

  // 每次都更新
  pickerRef && (pickerRef.current = {
    show: () => {
      setOpen(true);
    },
  });

  return <Modal
    title="选择图文"
    open={open}
    width={800}
    bodyStyle={{
      padding: '1rem',
    }}
    onOk={() => {
      if (id) {
        linkPicker.addValue({id}, {title});
      }
      setOpen(false);
    }}
    onCancel={() => {
      setOpen(false);
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
        url="articles"
        rowSelection={{
          type: 'radio',
          onChange: (selectedRowKeys, selectedRows) => {
            setId(selectedRowKeys[0]);
            setTitle(selectedRows[0]?.title);
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
  </Modal>;
};

ArticlePicker.propTypes = {
  pickerRef: PropTypes.object,
  linkPicker: PropTypes.object,
  value: PropTypes.object,
};

const ArticlePickerLabel = ({value, extra}) => {
  const [title, setTitle] = useState('');

  useEffect(() => {
    if (!extra.title) {
      (async () => {
        const {ret} = await $.get('articles/' + value.id);
        setTitle(ret.data.title);
      })();
    }
  }, [value.id, extra]);

  return extra.title || title;
};

ArticlePicker.Label = ArticlePickerLabel;

export default ArticlePicker;
