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
            NavigationLink(destination: NavigationLazyView(ListDataView()), tag: "home", selection: $selection) { EmptyView() }.isDetailLink(false)
            
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
            }.navigationBarTitle("Create / Post ", displayMode: .inline).navigationBarBackButtonHidden(true)
            .navigationBarItems(leading:Button(action: {
                selection = "home"
            }, label: {
                Image(systemName: "house")
            }),trailing:
                    Button(action: {
                        
                        let errorString = "false";
                        let successString = "true";
                        
                        // start processing save
                        let prefixUrl = "https://sponline.xyz/crud/simple_oop_proper.php"
                        
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
                        let task = URLSession.shared.dataTask(with: request) { (data,res,error) in
                            if error != nil {
                                
                            }
                            do {
                                if let data = data, let dataString = String(data: data, encoding: .utf8) {
                                    print(data)
                                    if(dataString.contains(successString)){
                                        selection = "home"
                                        
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
                    },label:{
                        Text("Save")
                    }) )
        }.alert(isPresented: $errorAlert, content: {
            Alert(title: Text("System"), message: Text("System had difficulity to conenct the server . Please try again dear."))
        }) // end vstack
    }
 // end zStack
}
struct DetailView_Previews: PreviewProvider {
    static var previews: some View {
        DetailView(name: "myname",  age: "12", personId: "12")
    }
}
