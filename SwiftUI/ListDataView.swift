import SwiftUI

struct ListDataView: View {
    @State  var model = [DataModel]()
    @State private var errorAlert: Bool = false
    @State private var selection: String? = nil
    
    var body: some View {
        NavigationLink(destination: NavigationLazyView(DetailView()), tag: "detail", selection: $selection) { EmptyView() }.isDetailLink(false)
        List {
           
            ForEach(model, id:\.personId){ item in
                NavigationLink(
                    destination: DetailView(name: item.name, age: item.age, personId: item.personId),
                    label: {
                        VStack(alignment:.leading){
                            HStack(alignment: .bottom) {
                                Text("Name :").font(.system(size: 14, weight: .bold))
                                Text(item.name).font(.system(size: 14, weight: .thin))
                            }
                            HStack(alignment: .bottom) {
                                Text("Age :").font(.system(size: 14, weight: .bold))
                                Text(String(item.age)).font(.system(size: 14, weight: .thin))
                            }
                        }
                    })
                
            }.onDelete(perform: { indexSet in
                let prefixUrl = "Your Server"
                let errorString = "false";
                let successString = "true";
                
                let personId = indexSet.map {
                    self.model[$0].personId
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
                
                let task = URLSession.shared.dataTask(with: request) { (data,res,error) in
                    if error != nil {
                        
                    }
                    do {
                        if let data = data, let dataString = String(data: data, encoding: .utf8) {
                            print(data)
                            if(dataString.contains(successString)){
                                // we can delete it , but better force refresh it
                                //indexSet.forEach { model.remove(at: $0) }
                                
                                read()
                            }else if(dataString.contains(errorString)){
                                let jsonData = dataString.data(using: .utf8)!
                                errorAlert = true
                                let result = try JSONDecoder().decode(FailureModel.self, from: jsonData )
                                print(result.code)
                                print(result.message)
                                
                            }else{
                                print("something really wrong")
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
                task.resume()
                // end
            })
        }.navigationBarTitle("Listing ", displayMode: .inline).navigationBarBackButtonHidden(true).navigationBarItems(
            trailing: Button(action: {
                // go back to previous page
                selection = "detail"
                print("selection ada ")
            },label :{
                Image(systemName: "plus")
            })).onAppear(){
                read()
            }
    }
    func read(){
        let prefixUrl = "Your Server"
        
        let url = URL(string: prefixUrl)!
        var request = URLRequest(url: url)
        request.httpMethod = "POST"
        
        var components = URLComponents(url: url, resolvingAgainstBaseURL: false)!
        
        components.queryItems = [
            URLQueryItem(name: "mode", value: "read")
        ]
        
        let query = components.url!.query
        request.httpBody = Data(query!.utf8)
        let task = URLSession.shared.dataTask(with: request) { (data,res,error) in
            
            if error != nil {
                print(error!)
            }else{
                print("no error ")
            }
            do {
                if let data = data {
                    let result = try JSONDecoder().decode(CrudModelRead.self, from: data )
                    // we only sync the detail value
                    model = result.data
                }else {
                    print ("No Data")
                    errorAlert = true
                }
            }catch let JsonError {
                print ("fetch json error ",JsonError.localizedDescription)
                errorAlert = true
            }
        }
        task.resume()
    }
}


struct ListDataView_Previews: PreviewProvider {
    static var previews: some View {
        ListDataView()
    }
}


