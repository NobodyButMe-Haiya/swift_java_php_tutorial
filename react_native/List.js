import React, { useState, useEffect } from 'react';
import { Button, View, Text, TouchableOpacity } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { ListItem, Avatar, Icon } from 'react-native-elements'
import { Component } from 'react';
import axios from 'axios';
/**
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
 **/
const list = [];

async function getList() {
    try {
        const {data:response} = await axios.get("#")
        return response.data
    }
    catch (error) {
        console.log(error);
    }
}
function ListScreen() {
    const navigation = useNavigation();

    let [list, setList] = useState('');

    useEffect(() => {
        let mounted = true;
        getList()
            .then(items => {
                if (mounted) {
                    setList(items)
                }
            })
        return () => mounted = false;
    }, [])
    function click() {
        navigation.navigate("Form")
    }
    function deleteRecord() {
        //later all change to fetch
        axios.post("#", {
            token: this.state.token,
            start: start,
            end: end,
            from: 'mobile'
        }).then(function (output) {
            console.log(output);
            output = output.data;
            if (output.Success == true) {

            } else {
                // something sweet alert later
            }
        }).catch(function (error) {
            console.log(error)
        });
    }
    return (<View>
        {
            list.map((l) => (
                <ListItem.Swipeable key={l.personId} bottomDivider

                                    rightContent={
                                        <Button
                                            title="Delete"
                                            icon={{ name: 'delete', color: 'white' }}
                                            buttonStyle={{ maxHeight: '100%', backgroundColor: 'red' }}
                                            onPress={click}
                                        />
                                    }>
                    <TouchableOpacity onPress={click} style={{ flex: 1 }}>
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