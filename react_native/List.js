import * as React from 'react';
import { Button, View, Text,TouchableOpacity } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { ListItem, Avatar,Icon } from 'react-native-elements'
import { Component } from 'react';
import { withNavigation } from 'react-navigation';

const list = [
  {
    name: 'holand',
    age: '23'
  },
  {
    name: 'Manahche',
    age: '34'
  },
]

function ListScreen() {
    const navigation = useNavigation();
    function click() {
      navigation.navigate("Form")
    }
    return(<View>
      {
        list.map((l, i) => (
          <ListItem.Swipeable key={i} bottomDivider 
        
          rightContent={
            <Button
              title="Delete"
              icon={{ name: 'delete', color: 'white' }}
              buttonStyle={{ maxHeight: '100%', backgroundColor: 'red' }}
              onPress={click}
            />
          }>  
            <TouchableOpacity onPress={click} style={{flex:1}}>
                <View>
                    <Text>{l.name}</Text>
                    <Text>{l.age}</Text>
                </View>
            </TouchableOpacity>
          </ListItem.Swipeable>
        ))
      }
    </View>)
  }
  export default ListScreen