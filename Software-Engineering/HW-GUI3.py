import tkinter as tk

class VendingMachine:
    def __init__(self, root):
        self.root = root
        self.root.title("Vending Machine")
        self.root.geometry("600x700")
        self.root.configure(bg="#f0f4f7")
        
        # สินค้าตัวอย่าง: ชื่อสินค้า, ราคา, จำนวนสินค้า
        self.products = [
            {"name": "Chocolate bar", "price": 12, "stock": 10},
            {"name": "Candy", "price": 7, "stock": 10},
            {"name": "Cracker", "price": 25, "stock": 7},
            {"name": "Cookies", "price": 29, "stock": 7},
            {"name": "Cola", "price": 20, "stock": 5},
        ]
        
        self.total_payment = 0
        self.total_input = 0
        self.selected_product = None
        
        # แบ่งส่วนต่าง ๆ ของ GUI
        self.create_widgets()
    
    def create_widgets(self):
        # แสดงรายการสินค้า
        self.product_frame = tk.Frame(self.root, bg="#e6efff", padx=10, pady=10, highlightbackground="#99c1f2", highlightthickness=2)
        self.product_frame.place(x=20, y=20, width=350, height=400)
        
        tk.Label(self.product_frame, text="Select products", font=("Arial", 16, "bold"), bg="#e6efff").pack(pady=10)
        
        self.product_buttons = []
        for product in self.products:
            product_btn = tk.Button(self.product_frame, text=f"{product['name']}", 
                                    command=lambda p=product: self.select_product(p),
                                    width=25, height=2, bg="#d8e4ff", font=("Arial", 12))
            product_btn.pack(pady=5)
            self.product_buttons.append(product_btn)
        
        # แสดงยอดเงินที่จ่ายและเงินทอน
        info_frame = tk.Frame(self.root, bg="#fff", padx=10, pady=10, highlightbackground="#c2cfdc", highlightthickness=2)
        info_frame.place(x=170, y=450, width=260, height=80)
        
        self.payment_label = tk.Label(info_frame, text=f"Payment amount : 0 baht", font=("Arial", 14), bg="#fff")
        self.payment_label.pack()
        
        self.change_label = tk.Label(info_frame, text=f"Change : 0 baht", font=("Arial", 14), bg="#fff")
        self.change_label.pack()
        
        # ปุ่มใส่เงิน
        money_frame = tk.Frame(self.root, bg="#f9f1e7", padx=10, pady=10, highlightbackground="#f7cfa1", highlightthickness=2)
        money_frame.place(x=380, y=20, width=200, height=400)
        
        tk.Label(money_frame, text="Insert money", font=("Arial", 16, "bold"), bg="#f9f1e7").pack()
        
        for denomination in [1, 2, 5, 10, 20]:
            tk.Button(money_frame, text=f"{denomination} baht", command=lambda d=denomination: self.insert_money(d),
                      width=12, height=2, bg="#f7cfa1", font=("Arial", 12)).pack(pady=10)
        
        # ปุ่มซื้อและปุ่มยกเลิกการซื้อ
        button_frame = tk.Frame(self.root, bg="#f0f4f7", padx=10, pady=10, highlightbackground="#a7b3c9", highlightthickness=2)
        button_frame.place(x=168, y=600, width=265, height=80)
        
        self.purchase_button = tk.Button(button_frame, text="Purchase", command=self.purchase, state=tk.DISABLED, 
                                         width=10, height=2, bg="#a3c2f5", font=("Arial", 12, "bold"))
        self.purchase_button.grid(row=0, column=0, padx=5)
        
        self.cancel_button = tk.Button(button_frame, text="Cancel", command=self.cancel, state=tk.DISABLED,
                                       width=10, height=2, bg="#f7a1a1", font=("Arial", 12, "bold"))
        self.cancel_button.grid(row=0, column=1, padx=5)
        
        # แสดงข้อความ
        self.message_label = tk.Label(self.root, text="", fg="red", font=("Arial", 12), bg="#f0f4f7")
        self.message_label.place(x=20, y=550, width=560)

    def select_product(self, product):
        if product['stock'] <= 0:
            self.message_label.config(text=f"{product['name']} is out of stock.")
            self.selected_product = None
            self.total_payment = 0
            self.payment_label.config(text=f"Payment amount : 0 baht")
            self.change_label.config(text=f"Change : 0 baht")
            self.purchase_button.config(state=tk.DISABLED)
            self.cancel_button.config(state=tk.DISABLED)
            return
        
        self.selected_product = product
        self.total_payment = self.selected_product['price']
        self.total_input = 0
        self.payment_label.config(text=f"Product Price : {self.total_payment} baht")
        self.change_label.config(text=f"Change : 0 baht")
        self.message_label.config(text=f"Select : {self.selected_product['name']} - {self.selected_product['price']} baht")
        self.purchase_button.config(state=tk.NORMAL)
        self.cancel_button.config(state=tk.NORMAL)
    
    def insert_money(self, amount):
        if self.selected_product:
            self.total_input += amount
            if self.total_input >= self.total_payment:
                self.change_label.config(text=f"Change : {self.total_input - self.total_payment} baht")
                self.message_label.config(text=f"The money is complete! please click 'Purchase' {self.selected_product['name']}.")
            else:
                self.message_label.config(text=f"Add more : {self.total_payment - self.total_input} baht")
            self.payment_label.config(text=f"money entered : {self.total_input} baht")
        else:
            self.message_label.config(text="Please select a product.")
    
    def purchase(self):
        if not self.selected_product:
            self.message_label.config(text="Please select a product.")
            return
        
        if self.selected_product['stock'] <= 0:
            self.message_label.config(text="Out of stock.")
            return
        
        if self.total_input < self.total_payment:
            self.message_label.config(text="Not enough money.")
            return
        
        self.selected_product['stock'] -= 1
        change = self.total_input - self.total_payment
        self.total_input = 0
        self.total_payment = 0
        self.payment_label.config(text=f"money entered : 0 baht")
        self.change_label.config(text=f"Change : 0 baht")
        
        self.message_label.config(text=f"Thank you! Change : {change} baht")
        self.selected_product = None
        self.purchase_button.config(state=tk.DISABLED)
        self.cancel_button.config(state=tk.DISABLED)
    
    def cancel(self):
        if self.total_input > 0:
            self.message_label.config(text=f"Refunds : {self.total_input} baht")
            self.selected_product = None
            self.total_input = 0
            self.total_payment = 0
            self.payment_label.config(text=f"Payment amount: 0 baht")
            self.change_label.config(text=f"Change : 0 baht")
            self.purchase_button.config(state=tk.DISABLED)
            self.cancel_button.config(state=tk.DISABLED)
        else:
            self.selected_product = None
            self.total_input = 0
            self.total_payment = 0
            self.message_label.config(text="There is no money to be returned.")
            self.payment_label.config(text=f"Payment amount: 0 baht")
            self.change_label.config(text=f"Change : 0 baht")
            self.purchase_button.config(state=tk.DISABLED)
            self.cancel_button.config(state=tk.DISABLED)
            
if __name__ == "__main__":
    root = tk.Tk()
    app = VendingMachine(root)
    root.mainloop()
