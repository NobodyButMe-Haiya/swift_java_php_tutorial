import React, { useState, useEffect } from 'react';
import {  View, Text, TouchableOpacity } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { ListItem, Button } from 'react-native-elements'
import axios from 'axios';

async function getList() {
    try {
        const { data: response } = await axios.get("#")
        return response.data
    }

    catch (error) {
        console.log(error);
    }
}
function ListScreen() {
    const navigation = useNavigation();

    let [list, setList] = useState([]);

    useEffect(() => {
        let mounted = true;
        const unsubscribe = navigation.addListener('focus', () => {
            // dam refersh .. no cached
            getList()
                .then(items => {
                    if (mounted) {
                        setList(items)
                    }
                })
        });
        console.log("are dam it refersg" )

        return () => mounted = false;
    }, [])
    // this type of function will load in the loop same as swift ui bugs.  it should be load upon clicked
    function click(name, age, personId) {
        console.log("name click event : " + name);
        console.log("age : " + age);
        console.log("personId : " + personId);


    }
    const formPage = (name, age, personId) => () => {
        console.log("name click event : " + name);
        console.log("age : " + age);
        console.log("personId : " + personId);
        navigation.navigate("Form", {
            nameRoute: name,
            ageRoute: age,
            personIdRoute: personId
        })
    }
    const deleteRecord = (personId) => () => {


        //later all change to fetch

        var formData = new FormData();
        formData.append("mode","delete");
        formData.append("personId",personId);
        axios.post('#',formData).then(function (output) {

            if (output.data.success == true) {
                console.log("record deleted")
                // reset and query back  ?
                const filteredData = list.filter(item => item.personId !== personId);
                setList(filteredData)

                // this is for purpose refresh and clear them item. rather then recursive better refresh
            } else {
                // something sweet alert later
                console.log("something wrong")

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
                                            onPress={deleteRecord(l.personId)}
                                        />
                                    }>
                    <TouchableOpacity onPress={formPage(l.name, l.age, l.personId)} style={{ flex: 1 }}>
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