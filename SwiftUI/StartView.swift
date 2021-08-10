import SwiftUI

struct StartView: View {
    var body: some View {
        // this is to prevent double navigation bar
        NavigationView {
            NavigationLink(destination: ListDataView(), label: {
                Text("Let Start")
            })
        }.navigationViewStyle(StackNavigationViewStyle())
    }
}

struct SwiftUIView_Previews: PreviewProvider {
    static var previews: some View {
        StartView()
    }
}
