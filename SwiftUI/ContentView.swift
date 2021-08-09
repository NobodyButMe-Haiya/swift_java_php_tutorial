//
//  ContentView.swift
//  swiftui_crud
//
//  Created by Hafizan Aziz on 08/08/2021.
//

import SwiftUI

struct ContentView: View {
    @EnvironmentObject var viewModel:ViewModel
    @State private var model = [DataModel]()
    @State private var errorAlert: Bool = false
    
    var body: some View {
        NavigationView {
            List {
                ForEach(model, id:\.personId){ item in
                    VStack(alignment:.leading){
                        Text(item.name)
                        Text(String(item.age))
                    }
                }.onDelete(perform: { indexSet in
                    let prefixUrl = "https://192.168.0.159/SP%20YOUTUBER/php%20base/CRUD/simple_oop_proper.php?"

                    let personId = indexSet.map {
                        self.model[$0].personId
                    }
                    DispatchQueue.main.async {
                        
                    }
                    // start back end
                    let url = URL(string: prefixUrl)!
                    var request = URLRequest(url: url)
                    request.httpMethod = "POST"
                    
                    var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
                    
                    components.queryItems = [
                        URLQueryItem(name: "personId", value: String(personId[0])),
                        URLQueryItem(name: "mode", value: "delete")
                    ]
                    
                    let query = components.url!.query
                    request.httpBody = Data(query!.utf8)
                    
                    URLSession.shared.dataTask(with: request) { (data,res,error) in
                        if error != nil {
                            
                        }
                        do {
                            if let data = data {
                                let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                                // later force refresh data
                                if result.success == true {
                                    // refresh the data
                                    viewModel.read()
                                    model = viewModel.items
                                }else {
                                    // alert end user
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
                    // end
                })
            }.onAppear(){
                // load data array here  not need published so on
                viewModel.read()
                model = viewModel.items
            }
        }
    }
    
}


struct ContentView_Previews: PreviewProvider {
    static var previews: some View {
        ContentView()
    }
}


