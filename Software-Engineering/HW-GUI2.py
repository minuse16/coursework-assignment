# import tkinter as tk
from tkinter import *


def on_click():
    usd = tv_thb.get() / 36.4
    tv_usd.set(f'{usd:.2f} usd.')


root = Tk()
root.option_add("*Font", "impact 20")
tv_thb = DoubleVar()
tv_usd = StringVar()

Entry(root, textvariable=tv_thb, width=7, justify="right").pack(side=LEFT, padx=10)
Label(root, text="THB.").pack(side=LEFT, padx=10)
Button(root, text=" = ", bg="green", command=on_click).pack(side=LEFT)
Label(root, textvariable=tv_usd).pack(side=LEFT)
root.mainloop()