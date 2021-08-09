//
//  DetailView .swift
//  swiftui_crud
//
//  Created by Hafizan Aziz on 08/08/2021.
//

import SwiftUI
import Combine
import Foundation

struct DetailView: View {
    @State var name = ""
    @State var age  = ""
    @State var personId = ""
    @State private var selection: String? = nil
    @State private var errorAlert: Bool = false
    var body: some View {
        ZStack {
            Color.gray.opacity(0.1).edgesIgnoringSafeArea(/*@START_MENU_TOKEN@*/.all/*@END_MENU_TOKEN@*/)
            NavigationLink(destination: NavigationLazyView(ContentView()), tag: "home", selection: $selection) { EmptyView() }.isDetailLink(false)
            
            VStack(alignment: .leading) {
                TextField("Name",text:$name)
                    .padding()
                    .background(Color.white)
                    .cornerRadius(6)
                    .padding(.bottom)
                
                TextField("Age",text:($age))
                    .padding()
                    .background(Color.white)
                    .cornerRadius(6)
                    .padding(.bottom)
                    .keyboardType(.numberPad)
                    .onReceive(Just(age)) { newValue in
                        let filtered = newValue.filter { "0123456789".contains($0) }
                        if filtered != newValue {
                            self.age = filtered
                        }
                    }
                Spacer()
            }.navigationTitle("Edit Post")
            .navigationBarItems(
                leading: Button(action: {
                    // go back to previous page
                    selection = "home"
                },label :{
                    Text("Cancel")
                }) ,trailing:
                    Button(action: {
                        // seperation is cool but much easier like this
                        // start processing save
                        let prefixUrl = "https://192.168.0.154/SP%20YOUTUBER/php%20base/CRUD/simple_oop_proper.php?"
                        
                        let url = URL(string: prefixUrl)!
                        var request = URLRequest(url: url)
                        request.httpMethod = "POST"
                        
                        var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
                        if  personId.isEmpty  {
                            
                            
                            components.queryItems = [
                                URLQueryItem(name: "name", value: name),
                                URLQueryItem(name: "age", value: String(age)),
                                URLQueryItem(name: "mode", value: "create")
                            ]
                            
                            
                        }else {
                            // update record
                            components.queryItems = [
                                URLQueryItem(name: "name", value: name),
                                URLQueryItem(name: "age", value: String(age)),
                                URLQueryItem(name: "personId", value: String(personId)),
                                URLQueryItem(name: "mode", value: "update")
                            ]
                        }
                        
                        let query = components.url!.query
                        request.httpBody = Data(query!.utf8)
                        URLSession.shared.dataTask(with: url) { (data,res,error) in
                            if error != nil {
                                
                            }
                            do {
                                if let data = data {
                                    let result = try JSONDecoder().decode(CrudModelOther.self, from: data )
                                    /// check status result if success
                                    if result.success == true  {
                                        selection = "home"
                                    }else {
                                        // alert end user something wrong with the server
                                        errorAlert = true
                                    }
                                }else {
                                    print ("No Data")
                                    errorAlert = true
                                }
                            }catch let JsonError {
                                print ("fetch json error ",JsonError.localizedDescription)
                                errorAlert = true
                            }
                        }
                    },label:{
                        Text("Save")
                    }) )
        }.alert(isPresented: $errorAlert, content: {
            Alert(title: Text("System"), message: Text("System had difficulity to conenct the server . Please try again dear."))
        }) // end vstack
    } // end zStack
}
struct DetailView_Previews: PreviewProvider {
    static var previews: some View {
        DetailView(name: "myname",  age: "12", personId: "12")
    }
}
