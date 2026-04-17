import tkinter as tk
from PIL import Image, ImageTk

class RevenueTracker:
    """คลาสสำหรับเก็บและติดตามรายได้ของร้าน"""
    def __init__(self):
        self.total_revenue = 0  # รายได้ทั้งหมด

    def add_revenue(self, amount):
        """เพิ่มรายได้"""
        self.total_revenue += amount

    def get_revenue(self):
        """แสดงรายได้สะสม"""
        return self.total_revenue


class VendingMachine:
    def __init__(self, root):
        self.root = root
        self.root.title("Vending Machine")
        self.root.geometry("600x750")
        self.root.configure(bg="#f0f4f7")
        
        # สินค้าตัวอย่าง: ชื่อสินค้า, ราคา, จำนวนสินค้า
        self.products = [
            {"name": "Chocolate bar", "price": 12, "stock": 10, "image": "D:/work/Software Lab/FinalTest/images/chocolate.jpg"},
            {"name": "Candy", "price": 7, "stock": 10, "image": "D:/work/Software Lab/FinalTest/images/candy.jpg"},
            {"name": "Cracker", "price": 25, "stock": 7, "image": "D:/work/Software Lab/FinalTest/images/cracker.jpg"},
            {"name": "Cookies", "price": 29, "stock": 7, "image": "D:/work/Software Lab/FinalTest/images/cookie.jpg"},
            {"name": "Gummy Bears", "price": 25, "stock": 5, "image": "D:/work/Software Lab/FinalTest/images/gummy bears.jpg"},
            {"name": "Fresh Milk", "price": 15, "stock": 10, "image": "D:/work/Software Lab/FinalTest/images/fresh milk.jpg"},
            {"name": "Yakult", "price": 10, "stock": 10, "image": "D:/work/Software Lab/FinalTest/images/yakult.jpg"},
            {"name": "Oishi", "price": 20, "stock": 5, "image": "D:/work/Software Lab/FinalTest/images/oishi.jpg"},
            {"name": "Cola", "price": 20, "stock": 5, "image": "D:/work/Software Lab/FinalTest/images/cola.jpg"},
        ]

        self.total_payment = 0
        self.total_input = 0
        self.selected_product = None

        # ประวัติการซื้อและรายได้
        self.purchase_history = []  
        self.revenue_tracker = RevenueTracker()  # สร้างคลาสติดตามรายได้

        self.create_widgets()

    def create_widgets(self):
        # สร้างกรอบสำหรับแสดงสินค้า
        self.product_frame = tk.Frame(self.root, bg="#e6efff", padx=10, pady=10, highlightbackground="#99c1f2", highlightthickness=2)
        self.product_frame.place(x=20, y=20, width=350, height=400)

        tk.Label(self.product_frame, text="Select products", font=("Arial", 16, "bold"), bg="#e6efff").pack(pady=10)

        # กำหนด scrollbar และ canvas
        self.scrollbar = tk.Scrollbar(self.product_frame)
        self.scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

        self.product_canvas = tk.Canvas(self.product_frame, bg="#e6efff", yscrollcommand=self.scrollbar.set)
        self.product_canvas.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)

        self.scrollbar.config(command=self.product_canvas.yview)

        # แสดงสินค้าทั้งหมด
        self.product_list_frame = tk.Frame(self.product_canvas, bg="#e6efff")
        self.product_canvas.create_window((0, 0), window=self.product_list_frame, anchor='nw')

        for index, product in enumerate(self.products):
            product_container = tk.Frame(self.product_list_frame, bg="#e6efff")
            product_container.grid(row=index // 2, column=index % 2, padx=10, pady=10)

            img_label = tk.Label(product_container, bg="#e6efff")
            img_label.pack()

            try:
                img = Image.open(product['image']).resize((100, 100))
                img = ImageTk.PhotoImage(img)
                img_label.config(image=img)
                img_label.image = img
            except FileNotFoundError:
                img_label.config(text="Image not found.")

            product_btn = tk.Button(product_container, text=f"{product['name']}", 
            command=lambda p=product: self.select_product(p),
            width=12, height=2, bg="#d8e4ff", font=("Arial", 12))
            product_btn.pack(pady=5)

        # อัปเดตขนาดของกรอบเลื่อน
        self.product_list_frame.update_idletasks()
        self.product_canvas.config(scrollregion=self.product_canvas.bbox("all"))

        # แสดงยอดเงินที่จ่ายและเงินทอน
        info_frame = tk.Frame(self.root, bg="#fff", padx=10, pady=10, highlightbackground="#c2cfdc", highlightthickness=2)
        info_frame.place(x=170, y=440, width=260, height=80)

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
        button_frame.place(x=168, y=570, width=265, height=80)

        self.purchase_button = tk.Button(button_frame, text="Purchase", command=self.purchase, state=tk.DISABLED, 
                                         width=10, height=2, bg="#a3c2f5", font=("Arial", 12, "bold"))
        self.purchase_button.grid(row=0, column=0, padx=5)

        self.cancel_button = tk.Button(button_frame, text="Cancel", command=self.cancel, state=tk.DISABLED,
                                       width=10, height=2, bg="#f7a1a1", font=("Arial", 12, "bold"))
        self.cancel_button.grid(row=0, column=1, padx=5)

        # ปุ่มดูประวัติการซื้อและรายได้สะสม
        self.history_button = tk.Button(self.root, text="Show Purchase History", command=self.show_history, 
                                        width=25, height=2, bg="#e6b3ff", font=("Arial", 12, "bold"))
        self.history_button.place(x=170, y=670)

        self.message_label = tk.Label(self.root, text="", fg="red", font=("Arial", 12), bg="#f0f4f7")
        self.message_label.place(x=20, y=530, width=560)

    def select_product(self, product):
        if product['stock'] <= 0:
            self.message_label.config(text=f"{product['name']} is out of stock.")
            self.reset_selection()
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
                self.message_label.config(text=f"The money is complete! Please click 'Purchase'.")
            else:
                self.message_label.config(text=f"Add more : {self.total_payment - self.total_input} baht")
            self.payment_label.config(text=f"Money entered : {self.total_input} baht")
        else:
            self.message_label.config(text="Please select a product.")

    def purchase(self):
        if self.total_input >= self.total_payment:
            self.selected_product['stock'] -= 1
            change = self.total_input - self.total_payment

            # บันทึกประวัติการซื้อและเพิ่มรายได้
            self.purchase_history.append({
                "product": self.selected_product['name'],
                "price": self.selected_product['price'],
                "input": self.total_input,
                "change": change
            })
            self.revenue_tracker.add_revenue(self.total_payment)  # เพิ่มรายได้

            self.message_label.config(text=f"Thank you! Change : {change} baht")
            self.reset_selection()
        else:
            self.message_label.config(text="Not enough money.")

    def cancel(self):
        if self.total_input > 0:
            self.message_label.config(text=f"Refunds : {self.total_input} baht")
        else:
            self.message_label.config(text="There is no money to be returned.")
        self.reset_selection()

    def reset_selection(self):
        self.selected_product = None
        self.total_input = 0
        self.total_payment = 0
        self.payment_label.config(text=f"Payment amount: 0 baht")
        self.change_label.config(text=f"Change : 0 baht")
        self.purchase_button.config(state=tk.DISABLED)
        self.cancel_button.config(state=tk.DISABLED)

    def show_history(self):
        history_window = tk.Toplevel(self.root)
        history_window.title("Purchase History")
        history_window.geometry("600x300")

        text_widget = tk.Text(history_window, wrap=tk.WORD, font=("Arial", 12))
        text_widget.pack(expand=True, fill=tk.BOTH)

        text_widget.tag_configure("center", justify='center', spacing1=5, spacing3=5)

        if not self.purchase_history:
            text_widget.insert(tk.END, "No purchase history available.\n", "center")
        else:
            for entry in self.purchase_history:
                text_widget.insert(
                    tk.END, 
                    f"Product: {entry['product']}, Price: {entry['price']} baht, Money: {entry['input']} baht, Change: {entry['change']} baht\n", 
                    "center"
                )
        
        # แสดงรายได้สะสมในหน้าต่างประวัติ
        text_widget.insert(tk.END, f"\nTotal Revenue: {self.revenue_tracker.get_revenue()} baht", "center")


if __name__ == "__main__":
    root = tk.Tk()
    app = VendingMachine(root)
    root.mainloop()