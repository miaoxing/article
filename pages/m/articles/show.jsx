import {Component} from 'react';
import {View, Text} from '@tarojs/components';
import './show.scss';
import Taro, {getCurrentInstance} from '@tarojs/taro';
import Ret from '@mxjs/m-ret';
import config from '@/config';

export default class Articles extends Component {
  state = {};

  componentDidMount() {
    const id = getCurrentInstance().router.params.id;
    Taro.request({
      url: config.apiUrl + '/articles/' + id,
      header: {
        ACCEPT: 'application/json',
      },
      success: ({data: ret}) => {
        if (ret.code !== 0) {
          Taro.showModal({
            content: ret.message,
            showCancel: false,
          });
          return;
        }

        this.setState(ret);
      },
    });
  }

  render() {
    const {data = {}} = this.state;

    return (
      <Ret ret={this.state}>
        <Article data={data}/>
      </Ret>
    );
  }
}

const Article = ({data}) => (
  <View className="article-content">
    <View className="article-title">{data.title}</View>

    <View className="article-meta">
      {data.author && <Text className="article-author">
        {data.author}
      </Text>}
      <Text className="article-time">
        {data.updatedAt.substr(0, 10)}
      </Text>
    </View>

    <View className="article-detail" dangerouslySetInnerHTML={{__html: data.detail.content}}/>
  </View>
);
